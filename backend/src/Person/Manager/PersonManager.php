<?php

namespace App\Person\Manager;

use App\Person\DTO\PersonDTO;
use App\Shared\Notify\Notify;

class PersonManager
{
    public function __construct(
        private readonly Notify         $notify,
        private readonly AddressManager $addressManager,
        private readonly ContactManager $contactManager
    )
    {
    }

    public function savePerson(PersonDTO $personDTO): void
    {
        $this->notify->addMessage($this->notify::WARNING, "Saving person");

        foreach($personDTO->getAddresses() as $address) {
            $this->addressManager->saveAddress($address);
        }
        foreach($personDTO->getContacts() as $contact) {
            $this->contactManager->saveContact($contact);
        }
    }
}