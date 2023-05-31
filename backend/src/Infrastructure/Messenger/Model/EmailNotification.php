<?php

namespace Panthir\Infrastructure\Messenger\Model;

class EmailNotification
{
    public function __construct(
        private readonly string $userEmail,
        private readonly string $resetPasswordtoken
    ) {
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    public function getResetPasswordtoken(): string
    {
        return $this->resetPasswordtoken;
    }
}