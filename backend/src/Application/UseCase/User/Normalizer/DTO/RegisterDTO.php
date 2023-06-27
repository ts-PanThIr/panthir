<?php

namespace Panthir\Application\UseCase\User\Normalizer\DTO;

use Panthir\Application\Common\DTO\DTOInterface;

class RegisterDTO implements DTOInterface
{
    public function __construct(
        public readonly string  $email,
        public readonly array   $roles = [],

        public readonly ?string $password = null,
        public readonly ?string $passwordResetToken = null
    )
    {
    }
}
