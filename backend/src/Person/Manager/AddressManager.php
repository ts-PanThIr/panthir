<?php

namespace App\Person\Manager;

use App\Person\DTO\PersonAddressDTO;
use App\Person\Entity\PersonAddressEntity;
use App\Shared\Notify\Notify;
use Doctrine\ORM\EntityManagerInterface;

class AddressManager
{
    public function __construct(
        private readonly Notify $notify,
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function saveAddress(PersonAddressDTO $addressDTO): void
    {
        $contact = new PersonAddressEntity();
        $contact
            ->setPerson($addressDTO->getPersonEntity())
            ->setAddress($addressDTO->getAddress())
            ->setAddressComplement($addressDTO->getAddressComplement())
            ->setCity($addressDTO->getCity())
            ->setCountry($addressDTO->getCountry())
            ->setDistrict($addressDTO->getDistrict())
            ->setNumber($addressDTO->getNumber())
            ->setZip($addressDTO->getZip())
        ;

        $this->entityManager->persist($contact);
        $this->notify->addMessage($this->notify::INFO, "Address saved");
    }
}
