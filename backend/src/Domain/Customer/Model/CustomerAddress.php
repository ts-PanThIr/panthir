<?php

namespace Panthir\Domain\Customer\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\Table(name: 'customer_address')]
final class CustomerAddress
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue('NONE')]
    private string $id;

    public function __construct(
        protected UuidInterface $uuid,

        #[ORM\Column]
        private string $name,

        #[ORM\Column]
        private string $country,

        #[ORM\Column]
        private string $district,

        #[ORM\Column]
        private string $city,

        #[ORM\Column]
        private string $address,

        #[ORM\Column]
        private string $number,

        #[ORM\Column]
        private string $zip,

        #[ManyToOne(targetEntity: Customer::class, inversedBy: "addresses")]
        #[JoinColumn(name: "customer_id", referencedColumnName: "id")]
        private Customer $customer,

        #[ORM\Column(nullable: true)]
        private ?string $addressComplement,
    )
    {
        $this->id = $uuid->__toString();
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity($city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress($address): self
    {
        $this->address = $address;
        return $this;
    }

    public function getDistrict(): ?string
    {
        return $this->district;
    }

    public function setDistrict($district): self
    {
        $this->district = $district;
        return $this;
    }

    public function getAddressComplement(): ?string
    {
        return $this->addressComplement;
    }

    public function setAddressComplement(?string $addressComplement): self
    {
        $this->addressComplement = $addressComplement;
        return $this;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber($number): self
    {
        $this->number = $number;
        return $this;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function setZip($zip): self
    {
        $this->zip = $zip;
        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }
}
