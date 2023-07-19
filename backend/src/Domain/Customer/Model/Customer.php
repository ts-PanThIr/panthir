<?php

namespace Panthir\Domain\Customer\Model;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Panthir\Domain\Common\Model\AbstractPerson;
use Panthir\Domain\Common\Model\CountableTrait;
use Panthir\Infrastructure\Repository\Person\CustomerRepository;
use Ramsey\Uuid\UuidInterface;

#[Entity(repositoryClass: CustomerRepository::class)]
#[ORM\Table(name: 'person')]
final class Customer extends AbstractPerson
{
    use CountableTrait;
    use BlameableEntity;
    use TimestampableEntity;

    public function __construct(
        string                        $name,
        string                        $document,
        public readonly UuidInterface $uuid,

        #[ORM\Column(name: 'surname')]
        public string                 $surname,

        #[ORM\OneToMany(mappedBy: "person", targetEntity: CustomerAddress::class, cascade: ["persist"])]
        public Collection             $addresses = new ArrayCollection(),

        #[ORM\OneToMany(mappedBy: "person", targetEntity: CustomerContact::class, cascade: ["persist"])]
        public Collection             $contacts = new ArrayCollection(),

        #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
        private ?DateTimeInterface    $birthDate = null,

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

    public function setBirthDate(?DateTimeInterface $birthDate): Customer
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function getBirthDate(): ?string
    {
        if (empty($this->birthDate)) {
            return null;
        }
        return date_format($this->birthDate, 'd/m/Y');
    }

    public function getRawBirthDate(): ?DateTimeInterface
    {
        return $this->birthDate;
    }

    public function addAddresses(CustomerAddress $address): self
    {
        if (!$this->addresses->contains($address)) {
            $address->person = $this;
            $this->addresses->add($address);
        }

        return $this;
    }

    public function removeAddresses(CustomerAddress $address): self
    {
        if ($this->addresses->contains($address)) {
            $this->addresses->removeElement($address);
        }

        return $this;
    }

    public function addContacts(CustomerContact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $contact->person = $this;
            $this->contacts->add($contact);
        }

        return $this;
    }

    public function removeContacts(CustomerContact $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
        }

        return $this;
    }
}
