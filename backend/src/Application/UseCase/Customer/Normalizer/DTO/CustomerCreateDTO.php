<?php

namespace Panthir\Application\UseCase\Customer\Normalizer\DTO;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Panthir\Application\Common\DTO\DTOInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CustomerCreateDTO implements DTOInterface
{
    private Collection $addresses;

    private Collection $contacts;

    public function __construct(

        #[Assert\NotBlank]
        public readonly string     $name,

        #[Assert\NotBlank]
        public readonly string     $surname,

        #[Assert\NotBlank]
        public readonly string     $document,

        private readonly ?DateTime $birthDate = null,

        public readonly ?string    $secondaryDocument = null,

        public readonly ?string    $additionalInformation = null
    )
    {
        $this->addresses = new ArrayCollection();
        $this->contacts = new ArrayCollection();
    }

    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function setAddresses(Collection $addresses): CustomerCreateDTO
    {
        $this->addresses = $addresses;
        return $this;
    }

    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function setContacts(Collection $contacts): CustomerCreateDTO
    {
        $this->contacts = $contacts;
        return $this;
    }

    public function addAddresses(CustomerAddressDTO $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses->add($address);
        }

        return $this;
    }

    public function removeAddresses(CustomerAddressDTO $address): self
    {
        if ($this->addresses->contains($address)) {
            $this->addresses->removeElement($address);
        }

        return $this;
    }

    public function addContacts(CustomerContactDTO $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
        }

        return $this;
    }

    public function removeContacts(CustomerContactDTO $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
        }

        return $this;
    }

    public function getBirthDate(): string
    {
        if (empty($this->birthDate)) {
            return '';
        }
        return date_format($this->birthDate, 'd/m/Y');
    }

    public function getRawBirthDate(): ?DateTime
    {
        return $this->birthDate;
    }
}
