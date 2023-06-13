<?php

namespace Panthir\Application\UseCase\User\Normalizer\DTO;

use Panthir\Application\Common\POPO\AbstractPOPO;
use Panthir\Application\Common\POPO\POPOInterface;

class PasswordRecoveryDTO extends AbstractPOPO implements POPOInterface
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