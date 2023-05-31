<?php

namespace App\Domain\Person\Manager;

use App\Domain\Person\Entity\PersonContactEntity;
use App\Shared\AbstractFactory;
use App\Shared\DTO\PersonContactPOPO;
use App\Shared\Exception\InvalidFieldException;
use App\Shared\Exception\ManagerException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContactFactory extends AbstractFactory
{
    public function __construct(
        EntityManagerInterface  $entityManager,
        private readonly ValidatorInterface     $validator
    )
    {
        parent::__construct(entityManager: $entityManager);
    }

    public function saveContact(PersonContactPOPO $contactDTO): PersonContactEntity
    {
        $errors = $this->validator->validate($contactDTO);

        if (count($errors) > 0) {
            throw new InvalidFieldException((string) $errors, 400);
        }

        if($contactDTO->getId()) {
            $contact = $this->entityManager->getRepository(PersonContactEntity::class)->find($contactDTO->getId());
            if (empty($contact)) {
                throw new ManagerException("Invalid Contact Id.", 400);
            }
        }
        else{
            $contact = new PersonContactEntity();
        }

        $contact
            ->setEmail($contactDTO->getEmail())
            ->setName($contactDTO->getName())
            ->setPhone($contactDTO->getPhone())
            ->setPerson($contactDTO->getPersonEntity())
        ;

        $this->entityManager->persist($contact);
        return $contact;
    }
}
