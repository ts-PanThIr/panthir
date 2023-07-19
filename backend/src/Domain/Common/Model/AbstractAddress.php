<?php

namespace Panthir\Domain\Common\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity]
abstract class AbstractAddress
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue('NONE')]
    protected string $id;

    #[ORM\Column]
    protected string $name;

    #[ORM\Column]
    protected string $country;

    #[ORM\Column]
    protected string $district;

    #[ORM\Column]
    protected string $city;

    #[ORM\Column]
    protected string $address;

    #[ORM\Column]
    protected string $number;

    #[ORM\Column]
    protected string $zip;

    #[ManyToOne(targetEntity: AbstractPerson::class, inversedBy: "addresses")]
    #[JoinColumn(name: "person_id", referencedColumnName: "id")]
    protected AbstractPerson $person;

    #[ORM\Column(nullable: true)]
    protected ?string $addressComplement;

    public function getId(): string
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

    public function getPerson(): AbstractPerson
    {
        return $this->person;
    }

    public function setPerson(AbstractPerson $person): AbstractAddress
    {
        $this->person = $person;
        return $this;
    }
}
