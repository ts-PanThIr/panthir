<?php

namespace App\User\Manager;

interface UserManagerInterface
{
    public function create(string $email, string $password);
    public function search();
}