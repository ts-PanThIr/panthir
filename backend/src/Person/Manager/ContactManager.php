<?php

namespace App\Person\Manager;

use App\Person\DTO\PersonContactDTO;
use App\Shared\Notify\Notify;

class ContactManager
{
    public function __construct(private readonly Notify $notify)
    {
    }

    public function saveContact(PersonContactDTO $contactDTO): void
    {
        $this->notify->addMessage($this->notify::WARNING, "Saving contact");
    }
}