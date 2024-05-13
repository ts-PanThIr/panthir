<?php

namespace Panthir\Application\UseCase\Customer\Normalizer\DTO;

use Panthir\Domain\Customer\ValueObject\AddressType;
use Panthir\Infrastructure\CommonBundle\Exception\InvalidFieldException;
use Symfony\Component\Validator\Constraints as Assert;

class CustomerAddressDTO
{
    private ?string $id = null;

    #[Assert\NotBlank]
    private string $country;

    #[Assert\NotBlank]
    private string $district;

    #[Assert\NotBlank]
    private string $city;

    #[Assert\NotBlank]
    private string $address;

    #[Assert\NotBlank]
    private string $number;

    #[Assert\NotBlank]
    private string $zip;

    #[Assert\NotBlank]
    private string $type;

    private ?string $addressComplement = null;

    private ?bool $delete = null;

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return $this
     */
    public function setId(?string $id): CustomerAddressDTO
    {
        $this->id = $id;
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
     * @return CustomerAddressDTO
     */
    public function setCountry(string $country): CustomerAddressDTO
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
     * @return CustomerAddressDTO
     */
    public function setDistrict(string $district): CustomerAddressDTO
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
     * @return CustomerAddressDTO
     */
    public function setCity(string $city): CustomerAddressDTO
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
     * @return CustomerAddressDTO
     */
    public function setAddress(string $address): CustomerAddressDTO
    {
        $this->address = $address;
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
     * @return CustomerAddressDTO
     */
    public function setNumber(string $number): CustomerAddressDTO
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
     * @return CustomerAddressDTO
     */
    public function setZip(string $zip): CustomerAddressDTO
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddressComplement(): ?string
    {
        return $this->addressComplement;
    }

    /**
     * @param string|null $addressComplement
     * @return CustomerAddressDTO
     */
    public function setAddressComplement(?string $addressComplement): CustomerAddressDTO
    {
        $this->addressComplement = $addressComplement;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /** @throws InvalidFieldException */
    public function setType(string $type): self
    {
        $enum = AddressType::tryFrom($type);
        if (!$enum) {
            throw new InvalidFieldException("Invalid type from customer's address", 400);
        }

        $this->type = $enum->value;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getDelete(): ?bool
    {
        return $this->delete;
    }

    /**
     * @param bool|null $delete
     * @return CustomerAddressDTO
     */
    public function setDelete(?bool $delete): CustomerAddressDTO
    {
        $this->delete = $delete;
        return $this;
    }

}
