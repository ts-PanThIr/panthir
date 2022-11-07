<?php

namespace App\Person\Manager;

use App\Person\DTO\PersonAddressDTO;
use App\Person\DTO\PersonContactDTO;
use App\Person\DTO\PersonDTO;
use App\Person\Entity\IndividualPersonEntity;
use App\Person\Entity\PersonEntity;
use App\Shared\Notify\Notify;
use Doctrine\ORM\EntityManagerInterface;

class PersonManager
{
    public function __construct(
        private readonly Notify                 $notify,
        private readonly AddressManager         $addressManager,
        private readonly ContactManager         $contactManager,
        private readonly EntityManagerInterface $entityManager
    )
    {
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
        ;
        $this->entityManager->persist($person);

        if ($personDTO->IsIndividual()) {
            if ($person->getIndividualPerson() == null) {
                $personIndividual = new IndividualPersonEntity();
            } else {
                $personIndividual = $this->entityManager->getRepository(IndividualPersonEntity::class)
                    ->findOneBy(["person" => $personDTO->getId()]);
                if (empty($personIndividual)) {
                    $this->notify->addMessage($this->notify::ERROR, "Invalid Id");
                    return null;
                }
            }

            $personIndividual
                ->setBirthDate($personDTO->getBirthDate())
                ->setDocument($personDTO->getDocument())
                ->setSecondaryDocument($personDTO->getSecondaryDocument())
                ->setSurname($personDTO->getSurname())
                ->setPerson($person)
            ;
            $this->entityManager->persist($personIndividual);
        }

        if (!$personDTO->IsIndividual()) {
            $this->notify->addMessage($this->notify::ERROR, "Not implemented method");
            return null;
        }

        /** @var PersonAddressDTO $address */
        foreach($personDTO->getAddresses() as $address) {
            $address->setIndividual($personDTO->IsIndividual());
            $address->setPersonEntity($person);
            $this->addressManager->saveAddress($address);
        }
        /** @var PersonContactDTO $contact */
        foreach($personDTO->getContacts() as $contact) {
            $contact->setIndividual($personDTO->IsIndividual());
            $contact->setPersonEntity($person);
            $this->contactManager->saveContact($contact);
        }

        $this->notify->addMessage($this->notify::INFO, "Person saved");
        return $person;
    }
}
