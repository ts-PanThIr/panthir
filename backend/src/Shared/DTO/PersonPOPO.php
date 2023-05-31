<?php

namespace App\Shared\DTO;

use App\Shared\Transformer\AbstractPOPOTransformer;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class PersonPOPO extends AbstractPOPOTransformer
{
    #[Groups(['person'])]
    private ?int $id = null;

    #[Groups(['person'])]
    #[Assert\NotBlank]
    private string $name;

    #[Groups(['person'])]
    #[Assert\NotBlank]
    private string $surname;

    #[Groups(['person'])]
    #[Assert\NotBlank]
    private string $document;

    #[Groups(['person'])]
    private ?string $additionalInformation = null;

    #[Groups(['person'])]
    private PersonAddressPOPO $mainAddress;

    #[Groups(['person'])]
    private PersonContactPOPO $mainContact;

    #[Groups(['person'])]
    private ?ArrayCollection $addresses = null;

    #[Groups(['person'])]
    private ?ArrayCollection $contacts = null;

    private ?DateTime $birthDate = null;

    #[Groups(['person'])]
    private ?string $secondaryDocument = null;

    #[Groups(['person'])]
    private DateTime $createdAt;

    #[Groups(['person'])]
    private UserInterface $createdBy;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): PersonPOPO
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): PersonPOPO
    {
        $this->name = $name;
        return $this;
    }

    public function getAdditionalInformation(): ?string
    {
        return $this->additionalInformation;
    }

    public function setAdditionalInformation(?string $additionalInformation): PersonPOPO
    {
        $this->additionalInformation = $additionalInformation;
        return $this;
    }

    public function getMainAddress(): PersonAddressPOPO
    {
        return $this->mainAddress;
    }

    public function setMainAddress(PersonAddressPOPO $mainAddress): PersonPOPO
    {
        $this->mainAddress = $mainAddress;
        return $this;
    }

    public function getMainContact(): PersonContactPOPO
    {
        return $this->mainContact;
    }

    public function setMainContact(PersonContactPOPO $mainContact): PersonPOPO
    {
        $this->mainContact = $mainContact;
        return $this;
    }

    public function getAddresses(): ?ArrayCollection
    {
        return $this->addresses;
    }

    public function addAddresses(PersonAddressPOPO $addressDTO): self
    {
        if (!$this->addresses->contains($addressDTO)) {
            $this->addresses->add($addressDTO);
        }
        return $this;
    }

    public function hasAddresses(): bool
    {
        return count($this->addresses) > 0;
    }

    public function removeAddresses(PersonAddressPOPO $addressDTO): self
    {
        if ($this->addresses->contains($addressDTO)) {
            $this->addresses->removeElement($addressDTO);
        }
        return $this;
    }

    public function setAddresses(ArrayCollection $addresses): self
    {
        $this->addresses = $addresses;
        return $this;
    }

    public function getContacts(): ?ArrayCollection
    {
        return $this->contacts;
    }

    public function setContacts(?ArrayCollection $contacts): self
    {
        $this->contacts = $contacts;
        return $this;
    }

    public function addContacts(PersonContactPOPO $contactDTO): self
    {
        if (!$this->contacts->contains($contactDTO)) {
            $this->contacts->add($contactDTO);
        }
        return $this;
    }

    public function removeContacts(PersonContactPOPO $contactDTO): self
    {
        if ($this->contacts->contains($contactDTO)) {
            $this->contacts->removeElement($contactDTO);
        }
        return $this;
    }

    public function hasContacts(): bool
    {
        return count($this->contacts) > 0;
    }

    public function getRawBirthDate(): ?DateTime
    {
        return $this->birthDate;
    }

    #[Groups(['person'])]
    public function getBirthDate(): String
    {
        if(empty($this->birthDate)) {
            return '';
        }
        return date_format($this->birthDate, 'd/m/Y');
    }

    public function setBirthDate(?DateTime $birthDate): PersonPOPO
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): PersonPOPO
    {
        $this->surname = $surname;
        return $this;
    }

    public function getDocument(): string
    {
        return $this->document;
    }

    public function setDocument(string $document): PersonPOPO
    {
        $this->document = $document;
        return $this;
    }

    public function getSecondaryDocument(): ?string
    {
        return $this->secondaryDocument;
    }

    public function setSecondaryDocument(?string $secondaryDocument): PersonPOPO
    {
        $this->secondaryDocument = $secondaryDocument;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): PersonPOPO
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCreatedBy(): UserInterface
    {
        return $this->createdBy;
    }

    public function setCreatedBy(UserInterface $createdBy): PersonPOPO
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    public static function transformFromObject(object $object): self
    {
        $dto = new PersonPOPO();
        $dto
            ->setAdditionalInformation($object->getAdditionalInformation())
            ->setAddresses(PersonAddressPOPO::transformFromObjectsToCollection($object->getAddresses()))
            ->setContacts(PersonContactPOPO::transformFromObjectsToCollection($object->getContacts()))
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
