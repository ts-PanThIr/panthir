<?php

namespace App\Person\DTO;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;

class PersonDTO
{
    private int $id;

    private string $name;

    private ?string $additionInformation = null;

    private bool $individual;

    private PersonAddressDTO $mainAddress;

    private PersonContactDTO $mainContact;

    private Collection $addresses;

    private Collection $contacts;

    private ?DateTime $birthDate = null;

    private ?string $surname = null;

    private ?string $nickname = null;

    private string $document;

    private ?string $secondaryDocument = null;

    private DateTime $createdAt;

    private UserInterface $createdBy;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->contacts = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return PersonDTO
     */
    public function setId(int $id): PersonDTO
    {
        $this->id = $id;
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
     * @return PersonDTO
     */
    public function setName(string $name): PersonDTO
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAdditionInformation(): ?string
    {
        return $this->additionInformation;
    }

    /**
     * @param string|null $additionInformation
     * @return PersonDTO
     */
    public function setAdditionInformation(?string $additionInformation): PersonDTO
    {
        $this->additionInformation = $additionInformation;
        return $this;
    }

    /**
     * @return bool
     */
    public function IsIndividual(): bool
    {
        return $this->individual;
    }

    /**
     * @param bool $individual
     * @return PersonDTO
     */
    public function setIndividual(bool $individual): PersonDTO
    {
        $this->individual = $individual;
        return $this;
    }

    /**
     * @return PersonAddressDTO
     */
    public function getMainAddress(): PersonAddressDTO
    {
        return $this->mainAddress;
    }

    /**
     * @param PersonAddressDTO $mainAddress
     * @return PersonDTO
     */
    public function setMainAddress(PersonAddressDTO $mainAddress): PersonDTO
    {
        $this->mainAddress = $mainAddress;
        return $this;
    }

    /**
     * @return PersonContactDTO
     */
    public function getMainContact(): PersonContactDTO
    {
        return $this->mainContact;
    }

    /**
     * @param PersonContactDTO $mainContact
     * @return PersonDTO
     */
    public function setMainContact(PersonContactDTO $mainContact): PersonDTO
    {
        $this->mainContact = $mainContact;
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
     * @param PersonAddressDTO $addressDTO
     * @return $this
     */
    public function addAddresses(PersonAddressDTO $addressDTO): self
    {
        if (!$this->addresses->contains($addressDTO)) {
            $this->addresses->add($addressDTO);
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function hasAddresses(): bool
    {
        return count($this->addresses) > 0;
    }

    /**
     * @param PersonAddressDTO $addressDTO
     * @return $this
     */
    public function removeAddresses(PersonAddressDTO $addressDTO): self
    {
        if ($this->addresses->contains($addressDTO)) {
            $this->addresses->removeElement($addressDTO);
        }
        return $this;
    }

    /**
     * @param Collection $addresses
     * @return PersonDTO
     */
    public function setAddresses(Collection $addresses): self
    {
        $this->addresses = $addresses;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    /**
     * @param Collection $contacts
     * @return PersonDTO
     */
    public function setContacts(Collection $contacts): self
    {
        $this->contacts = $contacts;
        return $this;
    }

    /**
     * @param PersonContactDTO $contactDTO
     * @return $this
     */
    public function addContacts(PersonContactDTO $contactDTO): self
    {
        if (!$this->contacts->contains($contactDTO)) {
            $this->contacts->add($contactDTO);
        }
        return $this;
    }

    /**
     * @param PersonContactDTO $contactDTO
     * @return $this
     */
    public function removeContacts(PersonContactDTO $contactDTO): self
    {
        if ($this->contacts->contains($contactDTO)) {
            $this->contacts->removeElement($contactDTO);
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function hasContacts(): bool
    {
        return count($this->contacts) > 0;
    }

    /**
     * @return ?DateTime
     */
    public function getBirthDate(): ?DateTime
    {
        return $this->birthDate;
    }

    /**
     * @return string
     */
    public function getFormattedBirthDate(): String
    {
        if(empty($this->birthDate)) {
            return '';
        }
        return date_format($this->birthDate, 'd-m-Y');
    }

    /**
     * @param DateTime $birthDate
     * @return PersonDTO
     */
    public function setBirthDate(DateTime $birthDate): PersonDTO
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string|null $surname
     * @return PersonDTO
     */
    public function setSurname(?string $surname): PersonDTO
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    /**
     * @param string|null $nickname
     * @return PersonDTO
     */
    public function setNickname(?string $nickname): PersonDTO
    {
        $this->nickname = $nickname;
        return $this;
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
     * @return PersonDTO
     */
    public function setDocument(string $document): PersonDTO
    {
        $this->document = $document;
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
     * @return PersonDTO
     */
    public function setSecondaryDocument(?string $secondaryDocument): PersonDTO
    {
        $this->secondaryDocument = $secondaryDocument;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return PersonDTO
     */
    public function setCreatedAt(DateTime $createdAt): PersonDTO
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getCreatedBy(): UserInterface
    {
        return $this->createdBy;
    }

    /**
     * @param UserInterface $createdBy
     * @return PersonDTO
     */
    public function setCreatedBy(UserInterface $createdBy): PersonDTO
    {
        $this->createdBy = $createdBy;
        return $this;
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
}
