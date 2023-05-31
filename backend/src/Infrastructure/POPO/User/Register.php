<?php

namespace Panthir\Infrastructure\POPO\User;

use Panthir\Infrastructure\POPO\AbstractPOPOTransformer;
use Panthir\Infrastructure\POPO\TransformFromRequestInterface;
use Symfony\Component\HttpFoundation\Request;

class Register extends AbstractPOPOTransformer implements TransformFromRequestInterface
{
    public function __construct(
        private readonly string  $email,
        private readonly array   $roles = [],
        private readonly ?string $password = null,
        private readonly ?string $passwordResetToken = null
    )
    {
    }

    public static function transformFromRequest(Request $object): self
    {
        return new self(
            email: $object->getEmail()
        );
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