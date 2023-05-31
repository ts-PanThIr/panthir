<?php

namespace Panthir\Infrastructure\Factory\User;

use App\Domain\User\UserRoles;
use App\Shared\Exception\ManagerException;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\LcobucciJWTEncoder;
use Panthir\Domain\User\Model\User;
use Panthir\Domain\User\ValueObject\UserId;
use Panthir\Infrastructure\Factory\AbstractFactory;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class UserCreateFactory extends AbstractFactory
{
    public function __construct(
        EntityManagerInterface                          $entityManager,
        protected           LcobucciJWTEncoder          $JWTEncoder,
        protected           MessageBusInterface         $bus,
        private             PasswordHasherInterface     $passwordHasher
    )
    {
        parent::__construct(entityManager: $entityManager);
    }

    public function execute($model): User
    {
        if (!filter_var($userDTO->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new ManagerException("The given e-mail is not valid.", 400);
        }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(["email" => $userDTO->getEmail()]);
        if(!empty($user)) {
            throw new ManagerException("There's already one user registered with this e-mail.", 400);
        }

        $resetToken = null;
        if(empty($userDTO->getPassword())){
            $current_time = time();
            $future_time = $current_time + (2 * 60 * 60);
            $expires_at = date('Y-m-d H:i:s', $future_time);

            $resetToken = base64_encode(
                $this->JWTEncoder->encode(['expires_at' => $expires_at])
            );
            $hashedPassword = $this->passwordHasher->hash(base64_encode(random_bytes(10)),null);
//            $this->bus->dispatch(new EmailNotification(userEmail: $user->getEmail(), resetPasswordtoken: $user->getPasswordResetToken()));

        } else{
            $hashedPassword = $this->passwordHasher->hash($userDTO->getPassword(),null);
        }

        $user = User::create(
            userId: new UserId(),
            email: $userDTO->getEmail(),
            roles: empty($userDTO->getRoles()) ? UserRoles::PROFILE_VIEWER : $userDTO->getRoles(),
            passwordResetToken: $resetToken,
            password: $hashedPassword
        );

        $this->entityManager->persist($user);

        return $user;
    }
}