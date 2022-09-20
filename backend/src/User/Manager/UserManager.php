<?php

namespace App\User\Manager;

use App\User\Entity\UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserManager implements UserManagerInterface
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly EntityManagerInterface      $entityManager
    )
    {
    }

    public function create
    (
        string $email,
        string $password
    ): void
    {
        $user = new UserEntity();
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $password
        );

        $user->setEmail($email)
            ->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function search () {
        
    }
}