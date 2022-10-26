<?php

namespace App\Person\Manager;

use App\Person\DTO\PersonAddressDTO;
use App\Person\Entity\PersonAddressEntity;
use App\Shared\Notify\Notify;
use Doctrine\ORM\EntityManagerInterface;

class AddressManager
{
    public function __construct(
        private readonly Notify                 $notify,
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function saveAddress(PersonAddressDTO $addressDTO): ?PersonAddressEntity
    {
        if($addressDTO->getId()) {
            $address = $this->entityManager->getRepository(PersonAddressEntity::class)->find($addressDTO->getId());
            if (empty($address)) {
                $this->notify->addMessage($this->notify::ERROR, "Invalid Address Id.");
                return null;
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
        $this->notify->addMessage($this->notify::INFO, "Address saved");
        return $address;
    }
}
