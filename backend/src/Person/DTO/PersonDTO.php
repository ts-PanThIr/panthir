<?php

namespace App\Person\DTO;

use App\Person\Entity\PersonAddressEntity;
use App\Person\Entity\PersonContactEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

class PersonDTO
{
    private int $id;

    private string $name;

    private ?string $additionInformation;

    private bool $isIndividual;

    private PersonAddressEntity $mainAddress;

    private PersonContactEntity $mainContact;

    private ArrayCollection $addresses;

    private ArrayCollection $contacts;

    private \DateTime $birthDate;

    private ?string $surname;

    private ?string $nickname;

    private string $document;

    private ?string $secondaryDocument;

    private \DateTime $createdAt;

    private UserInterface $createdBy;

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
    public function isIndividual(): bool
    {
        return $this->isIndividual;
    }

    /**
     * @param bool $isIndividual
     * @return PersonDTO
     */
    public function setIsIndividual(bool $isIndividual): PersonDTO
    {
        $this->isIndividual = $isIndividual;
        return $this;
    }

    /**
     * @return PersonAddressEntity
     */
    public function getMainAddress(): PersonAddressEntity
    {
        return $this->mainAddress;
    }

    /**
     * @param PersonAddressEntity $mainAddress
     * @return PersonDTO
     */
    public function setMainAddress(PersonAddressEntity $mainAddress): PersonDTO
    {
        $this->mainAddress = $mainAddress;
        return $this;
    }

    /**
     * @return PersonContactEntity
     */
    public function getMainContact(): PersonContactEntity
    {
        return $this->mainContact;
    }

    /**
     * @param PersonContactEntity $mainContact
     * @return PersonDTO
     */
    public function setMainContact(PersonContactEntity $mainContact): PersonDTO
    {
        $this->mainContact = $mainContact;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getAddresses(): ArrayCollection
    {
        return $this->addresses;
    }

    /**
     * @param ArrayCollection $addresses
     * @return PersonDTO
     */
    public function setAddresses(ArrayCollection $addresses): PersonDTO
    {
        $this->addresses = $addresses;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getContacts(): ArrayCollection
    {
        return $this->contacts;
    }

    /**
     * @param ArrayCollection $contacts
     * @return PersonDTO
     */
    public function setContacts(ArrayCollection $contacts): PersonDTO
    {
        $this->contacts = $contacts;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBirthDate(): \DateTime
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTime $birthDate
     * @return PersonDTO
     */
    public function setBirthDate(\DateTime $birthDate): PersonDTO
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
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return PersonDTO
     */
    public function setCreatedAt(\DateTime $createdAt): PersonDTO
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
}