<?php

namespace Panthir\Domain\Common\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait AddressTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['person'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['person'])]
    private string $name;

    #[ORM\Column]
    #[Groups(['person'])]
    private string $country;

    #[ORM\Column]
    #[Groups(['person'])]
    private string $district;

    #[ORM\Column]
    #[Groups(['person'])]
    private string $city;

    #[ORM\Column]
    #[Groups(['person'])]
    private string $address;

    #[ORM\Column(nullable: true)]
    #[Groups(['person'])]
    private ?string $addressComplement;

    #[ORM\Column]
    #[Groups(['person'])]
    private string $number;

    #[ORM\Column]
    #[Groups(['person'])]
    private string $zip;

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
