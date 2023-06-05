<?php

namespace Panthir\Domain\Person\Model;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: 'person')]
class Person
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
    private string $surname;

    #[ORM\Column]
    #[Groups(['person'])]
    private string $document;

    #[ORM\Column(nullable: true)]
    #[Groups(['person'])]
    private ?string $secondaryDocument = null;

    #[ORM\OneToOne(targetEntity: PersonAddress::class)]
    #[ORM\JoinColumn(name: "main_address_id", referencedColumnName: "id")]
    #[Groups(['person'])]
    private ?PersonAddress $mainAddress = null;

    /** TODO: replace main things for more specialized ones */

    #[ORM\OneToOne(targetEntity: PersonContact::class)]
    #[ORM\JoinColumn(name: "main_contact_id", referencedColumnName: "id")]
    #[Groups(['person'])]
    private ?PersonContact $mainContact = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['person'])]
    private ?DateTimeInterface $birthDate = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['person'])]
    private ?string $additionalInformation = null;

    #[ORM\OneToMany(mappedBy: "person", targetEntity: PersonAddress::class, cascade: ["persist"])]
    #[Groups(['person'])]
    private Collection $addresses;

    #[ORM\OneToMany(mappedBy: "person", targetEntity: PersonContact::class, cascade: ["persist"])]
    #[Groups(['person'])]
    private Collection $contacts;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->contacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;
        return $this;
    }

    public function getMainAddress(): ?PersonAddress
    {
        return $this->mainAddress;
    }

    public function setMainAddress(?PersonAddress $mainAddress): static
    {
        $this->mainAddress = $mainAddress;
        return $this;
    }

    public function getMainContact(): ?PersonContact
    {
        return $this->mainContact;
    }

    public function setMainContact(?PersonContact $mainContact): static
    {
        $this->mainContact = $mainContact;
        return $this;
    }

    public function getDocument(): string
    {
        return $this->document;
    }

    public function setDocument(string $document): static
    {
        $this->document = $document;
        return $this;
    }

    public function getSecondaryDocument(): ?string
    {
        return $this->secondaryDocument;
    }

    public function setSecondaryDocument(?string $secondaryDocument): static
    {
        $this->secondaryDocument = $secondaryDocument;
        return $this;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function getBirthDate(): ?String
    {
        if(empty($this->birthDate)) {
            return null;
        }
        return date_format($this->birthDate, 'd/m/Y');
    }

    public function getRawBirthDate(): ?DateTimeInterface
    {
        return $this->birthDate;
    }

    public function getAdditionalInformation(): ?string
    {
        return $this->additionalInformation;
    }

    public function setAdditionalInformation(?string $additionalInformation): static
    {
        $this->additionalInformation = $additionalInformation;
        return $this;
    }

    public function addAddresses(PersonAddress $address): self
    {
        if (!$this->addresses->contains($address)) {
            $address->setPerson($this);

            $this->addresses->add($address);
        }

        return $this;
    }

    public function removeAddresses(PersonAddress $address): self
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

    public function addContacts(PersonContact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $contact->setPerson($this);

            $this->contacts->add($contact);
        }

        return $this;
    }

    public function removeContacts(PersonContact $contact): self
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