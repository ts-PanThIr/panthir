<?php

namespace App\Person\Manager;

use App\Shared\DTO\PersonAddressDTO;
use App\Shared\DTO\PersonContactDTO;
use App\Shared\DTO\PersonDTO;
use App\Person\Entity\PersonEntity;
use App\Shared\AbstractManager;
use App\Shared\Exception\InvalidFieldException;
use App\Shared\Exception\ManagerException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PersonManager extends AbstractManager
{

    public function __construct(
        EntityManagerInterface  $entityManager,
        private readonly AddressManager         $addressManager,
        private readonly ContactManager         $contactManager,
        private readonly ValidatorInterface     $validator
    )
    {
        parent::__construct(entityManager: $entityManager);
    }

    /**
     * @param PersonDTO $personDTO
     * @return PersonEntity|null
     * @throws InvalidFieldException|ManagerException
     */
    public function savePerson(PersonDTO $personDTO): ?PersonEntity
    {
        $errors = $this->validator->validate($personDTO);

        if (count($errors) > 0) {
            throw new InvalidFieldException((string) $errors, 400);
        }

        if($personDTO->getId()) {
            $person = $this->entityManager->getRepository(PersonEntity::class)->find($personDTO->getId());
            if (empty($person)) {
                throw new ManagerException("The Id to update the person register is invalid.", 400);
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

        return $person;
    }
}
