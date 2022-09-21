<?php

namespace App\Shared\Notify;

interface NotifyInterface
{
    public function addMessage($type, $text);
    public function newReturn($data);
}