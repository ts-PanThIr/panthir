<?php

namespace Panthir\Application\UseCase\User\Normalizer\DTO;

use Panthir\Application\Common\DTO\DTOInterface;

class PasswordRecoveryDTO implements DTOInterface
{
    public function __construct(
        public readonly string  $email,
        public readonly ?string $password = null,
        public readonly ?string $passwordResetToken = null
    )
    {
    }
}
