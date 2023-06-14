<?php

namespace Panthir\Domain\Customer\Model;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Panthir\Infrastructure\Repository\Person\CustomerRepository;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ORM\Table(name: 'customer')]
final class Customer
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue('NONE')]
    private string $id;

    public function __construct(
        protected UuidInterface $uuid,

        #[ORM\Column]
        private string $name,

        #[ORM\Column]
        private string $surname,

        #[ORM\Column]
        private string $document,

        #[ORM\OneToMany(mappedBy: "customer", targetEntity: CustomerAddress::class, cascade: ["persist"])]
        private Collection $addresses = new ArrayCollection(),

        #[ORM\OneToMany(mappedBy: "customer", targetEntity: CustomerContact::class, cascade: ["persist"])]
        private Collection $contacts = new ArrayCollection(),

        #[ORM\Column(nullable: true)]
        private ?string $secondaryDocument = null,

        #[ORM\OneToOne(targetEntity: CustomerAddress::class)]
        #[ORM\JoinColumn(name: "main_address_id", referencedColumnName: "id")]
        private ?CustomerAddress $mainAddress = null,

        /** TODO: replace main addresses/contacts for more specialized ones */
        #[ORM\OneToOne(targetEntity: CustomerContact::class)]
        #[ORM\JoinColumn(name: "main_contact_id", referencedColumnName: "id")]
        private ?CustomerContact $mainContact = null,

        #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
        private ?DateTimeInterface $birthDate = null,

        #[ORM\Column(type: Types::TEXT, nullable: true)]
        private ?string $additionalInformation = null,
    )
    {
        $this->id = $uuid->__toString();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): Customer
    {
        $this->name = $name;
        return $this;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): Customer
    {
        $this->surname = $surname;
        return $this;
    }

    public function getMainAddress(): ?CustomerAddress
    {
        return $this->mainAddress;
    }

    public function setMainAddress(?CustomerAddress $mainAddress): Customer
    {
        $this->mainAddress = $mainAddress;
        return $this;
    }

    public function getMainContact(): ?CustomerContact
    {
        return $this->mainContact;
    }

    public function setMainContact(?CustomerContact $mainContact): Customer
    {
        $this->mainContact = $mainContact;
        return $this;
    }

    public function getDocument(): string
    {
        return $this->document;
    }

    public function setDocument(string $document): Customer
    {
        $this->document = $document;
        return $this;
    }

    public function getSecondaryDocument(): ?string
    {
        return $this->secondaryDocument;
    }

    public function setSecondaryDocument(?string $secondaryDocument): Customer
    {
        $this->secondaryDocument = $secondaryDocument;
        return $this;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): Customer
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

    public function setAdditionalInformation(?string $additionalInformation): Customer
    {
        $this->additionalInformation = $additionalInformation;
        return $this;
    }

    public function addAddresses(CustomerAddress $address): Customer
    {
        if (!$this->addresses->contains($address)) {
            $address->setCustomer($this);

            $this->addresses->add($address);
        }

        return $this;
    }

    public function removeAddresses(CustomerAddress $address): Customer
    {
        if ($this->addresses->contains($address)) {
            $address->setCustomer(null);

            $this->addresses->removeElement($address);
        }

        return $this;
    }

    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function setAddresses(ArrayCollection $address): Customer
    {
        $this->addresses = $address;

        return $this;
    }

    public function addContacts(CustomerContact $contact): Customer
    {
        if (!$this->contacts->contains($contact)) {
            $contact->setCustomer($this);

            $this->contacts->add($contact);
        }

        return $this;
    }

    public function removeContacts(CustomerContact $contact): Customer
    {
        if ($this->contacts->contains($contact)) {
            $contact->setCustomer(null);

            $this->contacts->removeElement($contact);
        }

        return $this;
    }

    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function setContacts(ArrayCollection $contact): Customer
    {
        $this->contacts = $contact;

        return $this;
    }
}
