<?php

namespace Panthir\Application\UseCase\User\Normalizer\DTO;

use Panthir\Application\Common\POPO\AbstractPOPO;
use Panthir\Application\Common\POPO\POPOInterface;

class RegisterDTO extends AbstractPOPO implements POPOInterface
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