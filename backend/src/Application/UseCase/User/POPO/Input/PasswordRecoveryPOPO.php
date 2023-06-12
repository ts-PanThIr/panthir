<?php

namespace Panthir\Application\UseCase\User\POPO\Input;

use Panthir\Application\Common\POPO\AbstractPOPO;
use Panthir\Application\Common\POPO\POPOInterface;

class PasswordRecoveryPOPO extends AbstractPOPO implements POPOInterface
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