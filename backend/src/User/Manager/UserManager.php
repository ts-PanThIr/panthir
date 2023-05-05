<?php

namespace App\User\Manager;

use App\Shared\AbstractManager;
use App\Shared\Notify\Notify;
use App\User\DTO\UserDTO;
use App\User\Entity\UserEntity;
use App\User\UserRoles;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserManager extends AbstractManager
{
    public function __construct(
                            EntityManagerInterface          $entityManager,
                            Notify                          $notify,
        protected readonly  UserPasswordHasherInterface     $passwordHasher,
        protected           JWTTokenManagerInterface        $JWTManager
    )
    {
        parent::__construct(entityManager: $entityManager, notify: $notify);
    }


    public function saveUser(UserDTO $userDTO): UserEntity
    {
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(["email" => $userDTO->getEmail()]);
        if(empty($user)) {
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

            //todo hook to send email to the invited user
        }

        $this->entityManager->persist($user);

        return $user;
    }

    public function search (): array
    {
        return $this->entityManager->getRepository(UserEntity::class)->findAll();
    }
}
