<?php

namespace App\Shared\DTO;

use App\Shared\Transformer\AbstractDTOTransformer;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class PersonDTO extends AbstractDTOTransformer
{
    #[Groups(['person'])]
    private ?int $id = null;

    #[Groups(['person'])]
    private string $name;

    #[Groups(['person'])]
    private ?string $additionalInformation = null;

    #[Groups(['person'])]
    private PersonAddressDTO $mainAddress;

    #[Groups(['person'])]
    private PersonContactDTO $mainContact;

    #[Groups(['person'])]
    private ?ArrayCollection $addresses = null;

    #[Groups(['person'])]
    private ?ArrayCollection $contacts = null;

    private ?DateTime $birthDate = null;

    #[Groups(['person'])]
    private ?string $surname = null;

    #[Groups(['person'])]
    private string $document;

    #[Groups(['person'])]
    private ?string $secondaryDocument = null;

    #[Groups(['person'])]
    private DateTime $createdAt;

    #[Groups(['person'])]
    private UserInterface $createdBy;

    /**
     * @return ?int
     */
    public function getId(): ?int
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
    public function getAdditionalInformation(): ?string
    {
        return $this->additionalInformation;
    }

    /**
     * @param string|null $additionalInformation
     * @return PersonDTO
     */
    public function setAdditionalInformation(?string $additionalInformation): PersonDTO
    {
        $this->additionalInformation = $additionalInformation;
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
     * @return ArrayCollection|null
     */
    public function getAddresses(): ?ArrayCollection
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
     * @param ArrayCollection $addresses
     * @return PersonDTO
     */
    public function setAddresses(ArrayCollection $addresses): self
    {
        $this->addresses = $addresses;
        return $this;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getContacts(): ?ArrayCollection
    {
        return $this->contacts;
    }

    /**
     * @param ArrayCollection|null $contacts
     * @return PersonDTO
     */
    public function setContacts(?ArrayCollection $contacts): self
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
    public function getRawBirthDate(): ?DateTime
    {
        return $this->birthDate;
    }

    /**
     * @return string
     */
    #[Groups(['person'])]
    public function getBirthDate(): String
    {
        if(empty($this->birthDate)) {
            return '';
        }
        return date_format($this->birthDate, 'd/m/Y');
    }

    /**
     * @param ?DateTime $birthDate
     * @return PersonDTO
     */
    public function setBirthDate(?DateTime $birthDate): PersonDTO
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

    /**
     * @param object $object
     * @return self
     */
    public static function transformFromObject(object $object): self
    {
        $dto = new PersonDTO();
        $dto
            ->setAdditionalInformation($object->getAdditionalInformation())
            ->setAddresses(PersonAddressDTO::transformFromObjectsToCollection($object->getAddresses()))
            ->setContacts(PersonContactDTO::transformFromObjectsToCollection($object->getContacts()))
            ->setName($object->getName())
            ->setId($object->getId())
            ->setBirthDate($object->getRawBirthDate())
            ->setDocument($object->getDocument())
            ->setSecondaryDocument($object->getSecondaryDocument())
            ->setSurname($object->getSurname())
        ;
        return $dto;
    }
}
