<?php

namespace Panthir\Domain\Supplier\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Panthir\Domain\Common\Model\AbstractPerson;
use Panthir\Domain\Common\Model\CountableTrait;
use Panthir\Infrastructure\Repository\Person\SupplierRepository;
use Ramsey\Uuid\UuidInterface;

#[Entity(repositoryClass: SupplierRepository::class)]
#[ORM\Table(name: 'person')]
final class Supplier extends AbstractPerson
{
    use CountableTrait;
    use BlameableEntity;
    use TimestampableEntity;

    public function __construct(
        string                        $name,
        string                        $document,

        public readonly UuidInterface $uuid,

        #[ORM\Column(name: 'surname')]
        public string                 $nickName,

        #[ORM\OneToMany(mappedBy: "person", targetEntity: SupplierAddress::class, cascade: ["persist"])]
        public Collection             $addresses = new ArrayCollection(),

        #[ORM\OneToMany(mappedBy: "person", targetEntity: SupplierContact::class, cascade: ["persist"])]
        public Collection             $contacts = new ArrayCollection(),

        string                        $secondaryDocument = null,
        string                        $additionalInformation = null,
    )
    {
        parent::__construct(
            id: $uuid->__toString(),
            document: $document,
            name: $name,
            secondaryDocument: $secondaryDocument,
            additionalInformation: $additionalInformation
        );
    }

    public function addAddresses(SupplierAddress $address): self
    {
        if (!$this->addresses->contains($address)) {
            $address->person = $this;
            $this->addresses->add($address);
        }

        return $this;
    }

    public function removeAddresses(SupplierAddress $address): self
    {
        if ($this->addresses->contains($address)) {
            $this->addresses->removeElement($address);
        }

        return $this;
    }

    public function addContacts(SupplierContact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $contact->person = $this;
            $this->contacts->add($contact);
        }

        return $this;
    }

    public function removeContacts(SupplierContact $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
        }

        return $this;
    }
}
