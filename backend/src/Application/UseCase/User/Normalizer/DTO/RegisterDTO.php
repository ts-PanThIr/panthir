<?php

namespace Panthir\Application\UseCase\User\Normalizer\DTO;

use Panthir\Application\Common\DTO\DTOInterface;

class RegisterDTO implements DTOInterface
{
    public function __construct(
        private readonly string  $email,
        private readonly array   $roles = [],

        private readonly ?string $password = null,
        private readonly ?string $passwordResetToken = null
    )
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getPasswordResetToken(): ?string
    {
        return $this->passwordResetToken;
    }
}
