<?php

namespace App\Person\Manager;

use App\Shared\DTO\PersonContactDTO;
use App\Person\Entity\PersonContactEntity;
use App\Shared\AbstractManager;
use App\Shared\Exception\InvalidFieldException;
use App\Shared\Exception\ManagerException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContactManager extends AbstractManager
{
    public function __construct(
        EntityManagerInterface  $entityManager,
        private readonly ValidatorInterface     $validator
    )
    {
        parent::__construct(entityManager: $entityManager);
    }

    public function saveContact(PersonContactDTO $contactDTO): PersonContactEntity
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
