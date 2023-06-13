<?php

namespace Panthir\Application\UseCase\User\Normalizer\DTO;

use Panthir\Application\Common\DTO\DTOInterface;

class PasswordRecoveryDTO implements DTOInterface
{
    public function __construct(
        private readonly string  $email
    )
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
