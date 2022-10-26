<?php

namespace App\Shared\EntityTraits;

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

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return self
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param $city
     * @return self
     */
    public function setCity($city): self
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param $address
     * @return self
     */
    public function setAddress($address): self
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDistrict(): ?string
    {
        return $this->district;
    }

    /**
     * @param $district
     * @return self
     */
    public function setDistrict($district): self
    {
        $this->district = $district;
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
     * @return self
     */
    public function setAddressComplement(?string $addressComplement): self
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
     * @param $number
     * @return self
     */
    public function setNumber($number): self
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
     * @param $zip
     * @return self
     */
    public function setZip($zip): self
    {
        $this->zip = $zip;
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
     * @return self
     */
    public function setCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }
}
