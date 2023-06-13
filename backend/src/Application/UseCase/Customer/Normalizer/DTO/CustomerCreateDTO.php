<?php

namespace Panthir\Application\UseCase\Customer\Normalizer\DTO;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Panthir\Application\Common\DTO\DTOInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CustomerCreateDTO implements DTOInterface
{
    public function __construct(

        #[Assert\NotBlank]
        private readonly string              $name,

        #[Assert\NotBlank]
        private readonly string              $surname,

        #[Assert\NotBlank]
        private readonly string              $document,

        private readonly ?CustomerAddressDTO $mainAddress = null,

        private readonly ?CustomerContactDTO $mainContact = null,

        private readonly Collection          $addresses = new ArrayCollection(),

        private readonly Collection          $contacts = new ArrayCollection(),

        private readonly ?DateTime           $birthDate = null,

        private readonly ?string             $secondaryDocument = null,

        private readonly ?string             $additionalInformation = null
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

    public function getAdditionalInformation(): ?string
    {
        return $this->additionalInformation;
    }

    public function getMainAddress(): ?CustomerAddressDTO
    {
        return $this->mainAddress;
    }

    public function getMainContact(): ?CustomerContactDTO
    {
        return $this->mainContact;
    }

    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function getRawBirthDate(): ?DateTime
    {
        return $this->birthDate;
    }

    public function getBirthDate(): string
    {
        if (empty($this->birthDate)) {
            return '';
        }
        return date_format($this->birthDate, 'd/m/Y');
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getDocument(): string
    {
        return $this->document;
    }

    public function getSecondaryDocument(): ?string
    {
        return $this->secondaryDocument;
    }
}
