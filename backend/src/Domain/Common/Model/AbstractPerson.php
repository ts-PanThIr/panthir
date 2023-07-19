<?php

namespace Panthir\Domain\Common\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Table(name: 'person')]
abstract class AbstractPerson
{
    use CountableTrait;
    use BlameableEntity;
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue('NONE')]
    protected string $id;

    #[ORM\Column]
    protected string $document;

    #[ORM\Column(name: 'name')]
    protected string $name;

    #[ORM\OneToMany(mappedBy: "person", targetEntity: AbstractAddress::class, cascade: ["persist"])]
    protected Collection $addresses;

    #[ORM\OneToMany(mappedBy: "person", targetEntity: AbstractContact::class, cascade: ["persist"])]
    protected Collection $contacts;

    #[ORM\Column(nullable: true)]
    protected ?string $secondaryDocument = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    protected ?string $additionalInformation = null;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->contacts = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDocument(): string
    {
        return $this->document;
    }

    public function setDocument(string $document): self
    {
        $this->document = $document;
        return $this;
    }

    public function getSecondaryDocument(): ?string
    {
        return $this->secondaryDocument;
    }

    public function setSecondaryDocument(?string $secondaryDocument): self
    {
        $this->secondaryDocument = $secondaryDocument;
        return $this;
    }

    public function getAdditionalInformation(): ?string
    {
        return $this->additionalInformation;
    }

    public function setAdditionalInformation(?string $additionalInformation): self
    {
        $this->additionalInformation = $additionalInformation;
        return $this;
    }

    public function addAddresses(AbstractAddress $address): self
    {
        if (!$this->addresses->contains($address)) {
            $address->setPerson($this);

            $this->addresses->add($address);
        }

        return $this;
    }

    public function removeAddresses(AbstractAddress $address): self
    {
        if ($this->addresses->contains($address)) {
            $address->setPerson(null);

            $this->addresses->removeElement($address);
        }

        return $this;
    }

    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function setAddresses(ArrayCollection $address): self
    {
        $this->addresses = $address;

        return $this;
    }

    public function addContacts(AbstractContact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $contact->setPerson($this);

            $this->contacts->add($contact);
        }

        return $this;
    }

    public function removeContacts(AbstractContact $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $contact->setPerson(null);

            $this->contacts->removeElement($contact);
        }

        return $this;
    }

    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function setContacts(ArrayCollection $contact): self
    {
        $this->contacts = $contact;

        return $this;
    }
}