<?php

namespace App\User\Manager;

use App\Shared\AbstractManager;
use App\Shared\Exception\ManagerException;
use App\Shared\Notify\Notify;
use App\Shared\DTO\UserDTO;
use App\User\Entity\UserEntity;
use App\User\Messenger\Model\EmailNotification;
use App\User\UserRoles;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserManager extends AbstractManager
{
    public function __construct(
        EntityManagerInterface                          $entityManager,
        private readonly Notify                         $notify,
        protected readonly  UserPasswordHasherInterface $passwordHasher,
        protected           JWTTokenManagerInterface    $JWTManager,
        protected           MessageBusInterface         $bus
    )
    {
        parent::__construct(entityManager: $entityManager);
    }


    /**
     * @throws ManagerException
     */
    public function createUser(UserDTO $userDTO): UserEntity
    {
        if (!filter_var($userDTO->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new ManagerException("The given e-mail is not valid.", 400);
        }

        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(["email" => $userDTO->getEmail()]);
        if(!empty($user)) {
            throw new ManagerException("There's already one user registered with this e-mail.", 400);
        }

        $current_time = time();
        $future_time = $current_time + (2 * 60 * 60);
        $expires_at = date('Y-m-d H:i:s', $future_time);

        $user = new UserEntity();
        $user->setEmail($userDTO->getEmail());
        $resetToken = base64_encode($this->JWTManager->createFromPayload($user, ['expires_at' => $expires_at]));

        if(empty($userDTO->getPassword())){
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                base64_encode(random_bytes(10))
            );
            $user->setPasswordResetToken($resetToken);
            $this->bus->dispatch(new EmailNotification(userEmail: $user->getEmail(), resetPasswordtoken: $user->getPasswordResetToken()));
        } else{
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $userDTO->getPassword()
            );
        }
        $user->setPassword($hashedPassword);

        $user->setRoles(UserRoles::PROFILE_VIEWER);
        if(!empty($userDTO->getRoles())){
            $user->setRoles($userDTO->getRoles());
        }
        $this->entityManager->persist($user);

        return $user;
    }

    public function sendPasswordRecoverNotification(UserDTO $userDTO): UserEntity
    {
        /** @var UserEntity $user */
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(["email" => $userDTO->getEmail()]);
        if(empty($user)) {
            throw new ManagerException("Was't possible to send the E-mail to reset user password.", 400);
        }

        $current_time = time();
        $future_time = $current_time + (2 * 60 * 60); // 2h
        $expires_at = date('Y-m-d H:i:s', $future_time);
        $resetToken = base64_encode($this->JWTManager->createFromPayload($user, ['expires_at' => $expires_at]));
        $user->setPasswordResetToken($resetToken);

        $this->entityManager->persist($user);
        $this->notify->addMessage($this->notify::INFO, 'Sending E-mail to reset user password');

        $this->bus->dispatch(new EmailNotification(userEmail: $user->getEmail(), resetPasswordtoken: $user->getPasswordResetToken()));

        return $user;
    }

    public function search (): array
    {
        return $this->entityManager->getRepository(UserEntity::class)->findAll();
    }
}
