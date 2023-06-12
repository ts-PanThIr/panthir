<?php

namespace Panthir\Application\UseCase\Customer\POPO\Input;

use Panthir\Application\Common\Transformer\AbstractPOPOTransformer;
use Panthir\Domain\Customer\Model\CustomerAddress;
use Symfony\Component\Validator\Constraints as Assert;

class CustomerAddressPOPO extends AbstractPOPOTransformer
{
    public function __construct(
        #[Assert\NotBlank]
        private readonly string  $name,

        #[Assert\NotBlank]
        private readonly string  $country,

        #[Assert\NotBlank]
        private readonly string  $district,

        #[Assert\NotBlank]
        private readonly string  $city,

        #[Assert\NotBlank]
        private readonly string  $address,

        #[Assert\NotBlank]
        private readonly string  $number,

        #[Assert\NotBlank]
        private readonly string  $zip,

        private readonly ?string $addressComplement = null,
    )
    {
    }

    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getDistrict(): string
    {
        return $this->district;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getAddressComplement(): ?string
    {
        return $this->addressComplement;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    /**
     * @param CustomerAddress $object
     * @return CustomerAddressPOPO
     */
    public static function transformFromObject(object $object): CustomerAddressPOPO
    {
        return new CustomerAddressPOPO(
            name: $object->getName(),
            country: $object->getCountry(),
            district: $object->getDistrict(),
            city: $object->getCity(),
            address: $object->getAddress(),
            number: $object->getNumber(),
            zip: $object->getZip(),
            addressComplement: $object->getAddressComplement()
        );
    }
}
