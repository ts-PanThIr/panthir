<?php

namespace App\Person\Manager;

use App\Person\DTO\PersonAddressDTO;
use App\Shared\Notify\Notify;

class AddressManager
{
    public function __construct(private readonly Notify $notify)
    {
    }

    public function saveAddress(PersonAddressDTO $addressDTO): void
    {
        $this->notify->addMessage($this->notify::WARNING, "Saving address");
    }
}