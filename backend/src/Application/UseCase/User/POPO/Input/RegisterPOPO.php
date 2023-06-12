<?php

namespace Panthir\Application\UseCase\User\POPO\Input;

use Panthir\Application\Common\POPO\AbstractPOPO;
use Panthir\Application\Common\POPO\POPOInterface;
use Panthir\Application\Common\Transformer\TransformFromRequestInterface;
use Symfony\Component\HttpFoundation\Request;

class RegisterPOPO extends AbstractPOPO implements TransformFromRequestInterface, POPOInterface
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
            email: $object->query->get('email')
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