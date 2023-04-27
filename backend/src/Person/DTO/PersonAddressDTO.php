<?php

namespace App\Person\DTO;

use App\Person\Entity\PersonAddressEntity;
use App\Person\Entity\PersonEntity;
use App\Shared\Transformer\AbstractDTOTransformer;
use Symfony\Component\Serializer\Annotation\Groups;

class PersonAddressDTO extends AbstractDTOTransformer
{
    #[Groups(['person'])]
    private ?int $id = null;

    #[Groups(['person'])]
    private string $name;

    #[Groups(['person'])]
    private string $country;

    #[Groups(['person'])]
    private string $district;

    #[Groups(['person'])]
    private string $city;

    #[Groups(['person'])]
    private string $address;

    #[Groups(['person'])]
    private ?string $addressComplement = null;

    #[Groups(['person'])]
    private string $number;

    #[Groups(['person'])]
    private string $zip;

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
     * @return PersonAddressDTO
     */
    public function setId(int $id): PersonAddressDTO
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
     * @return PersonAddressDTO
     */
    public function setCountry(string $country): PersonAddressDTO
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
     * @return PersonAddressDTO
     */
    public function setDistrict(string $district): PersonAddressDTO
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
     * @return PersonAddressDTO
     */
    public function setCity(string $city): PersonAddressDTO
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
     * @return PersonAddressDTO
     */
    public function setAddress(string $address): PersonAddressDTO
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
     * @return PersonAddressDTO
     */
    public function setAddressComplement(?string $addressComplement): PersonAddressDTO
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
     * @return PersonAddressDTO
     */
    public function setNumber(string $number): PersonAddressDTO
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
     * @return PersonAddressDTO
     */
    public function setZip(string $zip): PersonAddressDTO
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     * @return PersonEntity
     */
    public function getPersonEntity(): PersonEntity
    {
        return $this->personEntity;
    }

    /**
     * @param PersonEntity $personEntity
     * @return PersonAddressDTO
     */
    public function setPersonEntity(PersonEntity $personEntity): PersonAddressDTO
    {
        $this->personEntity = $personEntity;
        return $this;
    }

    /**
     * @param PersonAddressEntity $object
     * @return PersonAddressDTO
     */
    public static function transformFromObject(object $object): PersonAddressDTO
    {
        $dto = new PersonAddressDTO();
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
