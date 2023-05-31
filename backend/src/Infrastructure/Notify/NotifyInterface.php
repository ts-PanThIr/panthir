<?php

namespace Panthir\Infrastructure\Notify;

interface NotifyInterface
{
    public function addMessage($type, $text);
    public function newReturn($data);
}