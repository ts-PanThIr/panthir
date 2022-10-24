<?php

namespace App\Person\Manager;

use App\Person\DTO\PersonContactDTO;
use App\Person\Entity\PersonContactEntity;
use App\Shared\Notify\Notify;
use Doctrine\ORM\EntityManagerInterface;

class ContactManager
{
    public function __construct(
        private readonly Notify                 $notify,
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function saveContact(PersonContactDTO $contactDTO): ?PersonContactEntity
    {
        if($contactDTO->getId()) {
            $contact = $this->entityManager->getRepository(PersonContactEntity::class)->find($contactDTO->getId());
            if (empty($contact)) {
                $this->notify->addMessage($this->notify::ERROR, "Invalid Contact Id.");
                return null;
            }
        }
        else{
            $contact = new PersonContactEntity();
        }

        $contact
            ->setEmail($contactDTO->getEmail())
            ->setContactName($contactDTO->getName())
            ->setPhone($contactDTO->getPhone())
            ->setPerson($contactDTO->getPersonEntity())
        ;

        $this->entityManager->persist($contact);
        $this->notify->addMessage($this->notify::INFO, "Contact saved");
        return $contact;
    }
}
