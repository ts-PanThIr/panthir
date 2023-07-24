<?php

namespace Panthir\Application\UseCase\User\Normalizer\DTO;

use Panthir\Application\Common\DTO\DTOInterface;

class PasswordUpdateDTO implements DTOInterface
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly string $passwordResetToken
    )
    {
    }
}
