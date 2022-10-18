<?php

namespace App\Person\Manager;

use App\Person\DTO\PersonContactDTO;
use App\Person\Entity\PersonContactEntity;
use App\Shared\Notify\Notify;
use Doctrine\ORM\EntityManagerInterface;

class ContactManager
{
    public function __construct(
        private Notify $notify,
        private EntityManagerInterface $entityManager
    )
    {
    }

    public function saveContact(PersonContactDTO $contactDTO): void
    {
        $contact = new PersonContactEntity();
        $contact
            ->setEmail($contactDTO->getEmail())
            ->setContactName($contactDTO->getName())
            ->setPhone($contactDTO->getPhone())
        ;

        $this->entityManager->persist($contact);
        $this->notify->addMessage($this->notify::INFO, "Contact saved");
    }
}
