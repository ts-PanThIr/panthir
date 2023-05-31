<?php

namespace App\Domain\Person\Manager;

use App\Domain\Person\Entity\PersonAddressEntity;
use App\Shared\AbstractFactory;
use App\Shared\DTO\PersonAddressPOPO;
use App\Shared\Exception\InvalidFieldException;
use App\Shared\Exception\ManagerException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddressFactory extends AbstractFactory
{
    public function __construct(
        EntityManagerInterface  $entityManager,
        private readonly ValidatorInterface     $validator
    )
    {
        parent::__construct(entityManager: $entityManager);
    }

    public function saveAddress(PersonAddressPOPO $addressDTO): PersonAddressEntity
    {
        $errors = $this->validator->validate($addressDTO);

        if (count($errors) > 0) {
            throw new InvalidFieldException((string) $errors, 400);
        }

        if($addressDTO->getId()) {
            $address = $this->entityManager->getRepository(PersonAddressEntity::class)->find($addressDTO->getId());
            if (empty($address)) {
                throw new ManagerException("Invalid Address Id.", 400);
            }
        }
        else{
            $address = new PersonAddressEntity();
        }

        $address
            ->setName($addressDTO->getName())
            ->setPerson($addressDTO->getPersonEntity())
            ->setAddress($addressDTO->getAddress())
            ->setAddressComplement($addressDTO->getAddressComplement())
            ->setCity($addressDTO->getCity())
            ->setCountry($addressDTO->getCountry())
            ->setDistrict($addressDTO->getDistrict())
            ->setNumber($addressDTO->getNumber())
            ->setZip($addressDTO->getZip())
        ;

        $this->entityManager->persist($address);
        return $address;
    }
}
