<?php

namespace App\Person\Manager;

use App\Person\DTO\PersonAddressDTO;
use App\Person\DTO\PersonDTO;
use App\Person\Entity\IndividualPersonEntity;
use App\Person\Entity\PersonEntity;
use App\Shared\Notify\Notify;
use Doctrine\ORM\EntityManagerInterface;

class PersonManager
{
    public function __construct(
        private readonly Notify         $notify,
        private readonly AddressManager $addressManager,
        private readonly ContactManager $contactManager,
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function savePerson(PersonDTO $personDTO): void
    {
        $person = new PersonEntity();
        $person
            ->setName($personDTO->getName())
            ->setAdditionalInformation($personDTO->getAdditionInformation())
        ;
        $this->entityManager->persist($person);

        if ($personDTO->getIsIndividual()) {
            $personIndividual = new IndividualPersonEntity();
            $personIndividual
                ->setBirthDate($personDTO->getBirthDate())
                ->setDocument($personDTO->getDocument())
                ->setSecondaryDocument($personDTO->getSecondaryDocument())
                ->setSurname($personDTO->getSurname())
                ->setPerson($person)
            ;
            $this->entityManager->persist($personIndividual);
        }

        /** @var PersonAddressDTO $address */
        foreach($personDTO->getAddresses() as $address) {
            $address->setPersonEntity($personIndividual);
            $this->addressManager->saveAddress($address);
        }
        foreach($personDTO->getContacts() as $contact) {
            $this->contactManager->saveContact($contact);
        }

        $this->notify->addMessage($this->notify::INFO, "Person saved");
    }
}
