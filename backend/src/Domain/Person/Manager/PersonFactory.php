<?php

namespace App\Domain\Person\Manager;

use App\Domain\Person\Entity\PersonEntity;
use App\Shared\AbstractFactory;
use App\Shared\DTO\PersonAddressPOPO;
use App\Shared\DTO\PersonContactPOPO;
use App\Shared\DTO\PersonPOPO;
use App\Shared\Exception\InvalidFieldException;
use App\Shared\Exception\ManagerException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PersonFactory extends AbstractFactory
{

    public function __construct(
        EntityManagerInterface              $entityManager,
        private readonly AddressFactory     $addressManager,
        private readonly ContactFactory     $contactManager,
        private readonly ValidatorInterface $validator
    )
    {
        parent::__construct(entityManager: $entityManager);
    }

    /**
     * @param PersonPOPO $personDTO
     * @return \App\Domain\Person\Entity\PersonEntity|null
     * @throws InvalidFieldException|ManagerException
     */
    public function savePerson(PersonPOPO $personDTO): ?PersonEntity
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
            /** @var PersonAddressPOPO $address */
            foreach($personDTO->getAddresses() as $address) {
                $address->setPersonEntity($person);
                $this->addressManager->saveAddress($address);
            }
        }

        if(!empty($personDTO->getContacts())){
            /** @var PersonContactPOPO $contact */
            foreach($personDTO->getContacts() as $contact) {
                $contact->setPersonEntity($person);
                $this->contactManager->saveContact($contact);
            }
        }

        return $person;
    }
}
