<?php

namespace Panthir\Domain\Financial\Model;

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
use Panthir\Domain\Customer\Model\CustomerAddress;
use Panthir\Domain\Customer\Model\CustomerContact;
use Panthir\Infrastructure\Repository\Person\CustomerRepository;
use Ramsey\Uuid\UuidInterface;

#[Entity(repositoryClass: CustomerRepository::class)]
#[ORM\Table(name: 'title')]
final class Title extends AbstractPerson
{
    use CountableTrait;
    use BlameableEntity;
    use TimestampableEntity;

    private readonly UuidInterface $uuid;

    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue('NONE')]
    protected string $id;

    #[ORM\Column]
    protected string $document;

    #[ORM\Column(name: 'name')]
    protected string $name;

    #[ORM\Column(nullable: true)]
    protected ?string $secondaryDocument = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    protected ?string $additionalInformation = null;

    #[ORM\Column(name: 'surname')]
    private string $surname;

    #[ORM\OneToMany(mappedBy: "person", targetEntity: CustomerAddress::class, cascade: ["persist"])]
    private Collection $addresses;

    #[ORM\OneToMany(mappedBy: "person", targetEntity: CustomerContact::class, cascade: ["persist"])]
    private Collection $contacts;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $birthDate = null;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->contacts = new ArrayCollection();
    }

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @param UuidInterface $uuid
     * @return $this
     */
    public function setUuid(UuidInterface $uuid): self
    {
        $this->uuid = $uuid;
        $this->id = $uuid->toString();

        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDocument(): string
    {
        return $this->document;
    }

    /**
     * @param string $document
     * @return $this
     */
    public function setDocument(string $document): self
    {
        $this->document = $document;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSecondaryDocument(): ?string
    {
        return $this->secondaryDocument;
    }

    /**
     * @param string|null $secondaryDocument
     * @return $this
     */
    public function setSecondaryDocument(?string $secondaryDocument): self
    {
        $this->secondaryDocument = $secondaryDocument;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAdditionalInformation(): ?string
    {
        return $this->additionalInformation;
    }

    /**
     * @param string|null $additionalInformation
     * @return $this
     */
    public function setAdditionalInformation(?string $additionalInformation): self
    {
        $this->additionalInformation = $additionalInformation;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return $this
     */
    public function setSurname(string $surname): Title
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @param DateTimeInterface|null $birthDate
     * @return $this
     */
    public function setBirthDate(?DateTimeInterface $birthDate): Title
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBirthDate(): ?string
    {
        if (empty($this->birthDate)) {
            return null;
        }
        return date_format($this->birthDate, 'd/m/Y');
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getRawBirthDate(): ?DateTimeInterface
    {
        return $this->birthDate;
    }

    /**
     * @param CustomerAddress $address
     * @return $this
     */
    public function addAddresses(CustomerAddress $address): self
    {
        if (!$this->addresses->contains($address)) {
            $address->setPerson($this);
            $this->addresses->add($address);
        }

        return $this;
    }

    /**
     * @param CustomerAddress $address
     * @return $this
     */
    public function removeAddresses(CustomerAddress $address): self
    {
        if ($this->addresses->contains($address)) {
            $this->addresses->removeElement($address);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    /**
     * @param CustomerContact $contact
     * @return $this
     */
    public function addContacts(CustomerContact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $contact->setPerson($this);
            $this->contacts->add($contact);
        }

        return $this;
    }

    /**
     * @param CustomerContact $contact
     * @return $this
     */
    public function removeContacts(CustomerContact $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }
}
