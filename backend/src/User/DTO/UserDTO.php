<?php

namespace App\User\DTO;

use App\Shared\Transformer\AbstractDTOTransformer;
use Symfony\Component\Serializer\Annotation\Groups;

class UserDTO extends AbstractDTOTransformer
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
        return new UserDTO(
            email: $object->getEmail()
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): UserDTO
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): UserDTO
    {
        $this->email = $email;
        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): UserDTO
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): UserDTO
    {
        $this->password = $password;
        return $this;
    }

    public function getPasswordResetToken(): ?string
    {
        return $this->passwordResetToken;
    }

    public function setPasswordResetToken(?string $passwordResetToken): UserDTO
    {
        $this->passwordResetToken = $passwordResetToken;
        return $this;
    }
}
