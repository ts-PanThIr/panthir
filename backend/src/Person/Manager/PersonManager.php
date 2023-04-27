<?php

namespace App\Person\Manager;

use App\Person\DTO\PersonAddressDTO;
use App\Person\DTO\PersonContactDTO;
use App\Person\DTO\PersonDTO;
use App\Person\Entity\PersonEntity;
use App\Shared\AbstractManager;
use App\Shared\Notify\Notify;
use Doctrine\ORM\EntityManagerInterface;

class PersonManager extends AbstractManager
{

    public function __construct(
        Notify                  $notify,
        EntityManagerInterface  $entityManager,
        private readonly AddressManager         $addressManager,
        private readonly ContactManager         $contactManager
    )
    {
        parent::__construct(entityManager: $entityManager, notify: $notify);
    }

    /**
     * @param PersonDTO $personDTO
     * @return PersonEntity|null
     */
    public function savePerson(PersonDTO $personDTO): ?PersonEntity
    {
        if($personDTO->getId()) {
            $person = $this->entityManager->getRepository(PersonEntity::class)->find($personDTO->getId());
            if (empty($person)) {
                $this->notify->addMessage($this->notify::ERROR, "Invalid Id");
                return null;
            }
        }
        else{
            $person = new PersonEntity();
        }
        $person
            ->setName($personDTO->getName())
            ->setAdditionalInformation($personDTO->getAdditionalInformation())
            ->setBirthDate($personDTO->getRawBirthDate())
            ->setDocument($personDTO->getDocument())
            ->setSecondaryDocument($personDTO->getSecondaryDocument())
            ->setSurname($personDTO->getSurname())
        ;
        $this->entityManager->persist($person);


        if(!empty($personDTO->getAddresses())){
            /** @var PersonAddressDTO $address */
            foreach($personDTO->getAddresses() as $address) {
                $address->setPersonEntity($person);
                $this->addressManager->saveAddress($address);
            }
        }

        if(!empty($personDTO->getContacts())){
            /** @var PersonContactDTO $contact */
            foreach($personDTO->getContacts() as $contact) {
                $contact->setPersonEntity($person);
                $this->contactManager->saveContact($contact);
            }
        }

        $this->notify->addMessage($this->notify::INFO, "Person saved");
        return $person;
    }
}
