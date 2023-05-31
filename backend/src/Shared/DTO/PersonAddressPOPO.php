<?php

namespace App\Shared\DTO;

use App\Domain\Person\Entity\PersonAddressEntity;
use App\Domain\Person\Entity\PersonEntity;
use App\Shared\Transformer\AbstractPOPOTransformer;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class PersonAddressPOPO extends AbstractPOPOTransformer
{
    #[Groups(['person'])]
    private ?int $id = null;

    #[Groups(['person'])]
    #[Assert\NotBlank]
    private string $name;

    #[Groups(['person'])]
    #[Assert\NotBlank]
    private string $country;

    #[Groups(['person'])]
    #[Assert\NotBlank]
    private string $district;

    #[Groups(['person'])]
    #[Assert\NotBlank]
    private string $city;

    #[Groups(['person'])]
    #[Assert\NotBlank]
    private string $address;

    #[Groups(['person'])]
    private ?string $addressComplement = null;

    #[Groups(['person'])]
    #[Assert\NotBlank]
    private string $number;

    #[Groups(['person'])]
    #[Assert\NotBlank]
    private string $zip;

    #[Assert\NotBlank]
    private PersonEntity $personEntity;

    /**
     * @return ?int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return PersonAddressPOPO
     */
    public function setId(int $id): PersonAddressPOPO
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return PersonAddressPOPO
     */
    public function setCountry(string $country): PersonAddressPOPO
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getDistrict(): string
    {
        return $this->district;
    }

    /**
     * @param string $district
     * @return PersonAddressPOPO
     */
    public function setDistrict(string $district): PersonAddressPOPO
    {
        $this->district = $district;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return PersonAddressPOPO
     */
    public function setCity(string $city): PersonAddressPOPO
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return PersonAddressPOPO
     */
    public function setAddress(string $address): PersonAddressPOPO
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return ?string
     */
    public function getAddressComplement(): ?string
    {
        return $this->addressComplement;
    }

    /**
     * @param ?string $addressComplement
     * @return PersonAddressPOPO
     */
    public function setAddressComplement(?string $addressComplement): PersonAddressPOPO
    {
        $this->addressComplement = $addressComplement;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return PersonAddressPOPO
     */
    public function setNumber(string $number): PersonAddressPOPO
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string
     */
    public function getZip(): string
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     * @return PersonAddressPOPO
     */
    public function setZip(string $zip): PersonAddressPOPO
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     * @return \App\Domain\Person\Entity\PersonEntity
     */
    public function getPersonEntity(): PersonEntity
    {
        return $this->personEntity;
    }

    /**
     * @param \App\Domain\Person\Entity\PersonEntity $personEntity
     * @return PersonAddressPOPO
     */
    public function setPersonEntity(PersonEntity $personEntity): PersonAddressPOPO
    {
        $this->personEntity = $personEntity;
        return $this;
    }

    /**
     * @param PersonAddressEntity $object
     * @return PersonAddressPOPO
     */
    public static function transformFromObject(object $object): PersonAddressPOPO
    {
        $dto = new PersonAddressPOPO();
        return $dto
            ->setId($object->getId())
            ->setName($object->getName())
            ->setAddress($object->getAddress())
            ->setAddressComplement($object->getAddressComplement())
            ->setCity($object->getCity())
            ->setCountry($object->getCountry())
            ->setDistrict($object->getDistrict())
            ->setNumber($object->getNumber())
            ->setZip($object->getZip())
        ;
    }
}
