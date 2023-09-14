<?php

namespace Panthir\Application\UseCase\Supplier\Normalizer\DTO;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Panthir\Application\Common\DTO\DTOInterface;
use Symfony\Component\Validator\Constraints as Assert;

class SupplierCreateDTO implements DTOInterface
{
    public readonly Collection $addresses;

    public readonly Collection $contacts;

    public function __construct(

        #[Assert\NotBlank]
        public readonly string          $name,

        #[Assert\NotBlank]
        public readonly string          $nickName,

        #[Assert\NotBlank]
        public readonly string          $document,

        public readonly ?string         $secondaryDocument = null,

        public readonly ?string         $additionalInformation = null
    )
    {
        $this->addresses = new ArrayCollection();
        $this->contacts = new ArrayCollection();
    }

    public function addContacts(SupplierContactDTO $contact): self
    {
        if (!$this->contacts->contains($contact)) {
//            $contact->person = $this;
            $this->contacts->add($contact);
        }

        return $this;
    }

    public function removeContacts(SupplierContactDTO $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
        }

        return $this;
    }

    public function addAddresses(SupplierAddressDTO $address): self
    {
        if (!$this->addresses->contains($address)) {
//            $address->person = $this;
            $this->addresses->add($address);
        }

        return $this;
    }

    public function removeAddresses(SupplierAddressDTO $address): self
    {
        if ($this->addresses->contains($address)) {
            $this->addresses->removeElement($address);
        }

        return $this;
    }
}
