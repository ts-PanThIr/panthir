<?php

namespace App\Shared\DTO;

use App\Shared\Transformer\AbstractPOPOTransformer;
use Symfony\Component\Serializer\Annotation\Groups;

class UserPOPO extends AbstractPOPOTransformer
{
    public function __construct(
        #[Groups(['user'])]
        private string $email,

        #[Groups(['user'])]
        private ?int $id = null,

        #[Groups(['user'])]
        private array $roles = [],

        private ?string $password = null,
        private ?string $passwordResetToken = null
    )
    {
    }

    public static function transformFromObject(object $object): self
    {
        return new UserPOPO(
            email: $object->getEmail()
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): UserPOPO
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): UserPOPO
    {
        $this->email = $email;
        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): UserPOPO
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): UserPOPO
    {
        $this->password = $password;
        return $this;
    }

    public function getPasswordResetToken(): ?string
    {
        return $this->passwordResetToken;
    }

    public function setPasswordResetToken(?string $passwordResetToken): UserPOPO
    {
        $this->passwordResetToken = $passwordResetToken;
        return $this;
    }
}
