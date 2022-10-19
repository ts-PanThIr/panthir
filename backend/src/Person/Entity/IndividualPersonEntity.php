<?php

namespace App\Person\Entity;

use App\Person\Repository\IndividualPersonRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IndividualPersonRepository::class)]
#[ORM\Table(name: 'person_individual')]
class IndividualPersonEntity
{
    use BlameableEntity;
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['person'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    #[Groups(['person'])]
    private ?DateTimeInterface $birthDate = null;

    #[ORM\Column]
    #[Groups(['person'])]
    private string $surname;

    #[ORM\Column]
    #[Groups(['person'])]
    private string $document;

    #[ORM\Column]
    #[Groups(['person'])]
    private string $secondaryDocument;

    #[ORM\OneToOne(targetEntity: PersonEntity::class)]
    #[ORM\JoinColumn(name: "person_id", referencedColumnName: "id")]
    #[Groups(['person'])]
    private PersonEntity $person;

    #[ORM\OneToOne(targetEntity: PersonAddressEntity::class)]
    #[ORM\JoinColumn(name: "main_address_id", referencedColumnName: "id")]
    #[Groups(['person'])]
    private ?PersonAddressEntity $mainAddress = null;

    #[ORM\OneToOne(targetEntity: PersonContactEntity::class)]
    #[ORM\JoinColumn(name: "main_contact_id", referencedColumnName: "id")]
    #[Groups(['person'])]
    private ?PersonContactEntity $mainContact = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return String
     */
    public function getBirthDate(): String
    {
        if(empty($this->birthDate)) {
            return '';
        }
        return $this->birthDate;
    }

    /**
     * @param null|DateTimeInterface $birthDate
     * @return self
     */
    public function setBirthDate(?\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;
        return $this;
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
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return self
     */
    public function setSurname(string $surname): static
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return PersonEntity
     */
    public function getPerson(): PersonEntity
    {
        return $this->person;
    }

    /**
     * @param PersonEntity $person
     * @return self
     */
    public function setPerson(PersonEntity $person): static
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return PersonAddressEntity|null
     */
    public function getMainAddress(): ?PersonAddressEntity
    {
        return $this->mainAddress;
    }

    /**
     * @param PersonAddressEntity|null $mainAddress
     * @return self
     */
    public function setMainAddress(?PersonAddressEntity $mainAddress): static
    {
        $this->mainAddress = $mainAddress;
        return $this;
    }

    /**
     * @return PersonContactEntity|null
     */
    public function getMainContact(): ?PersonContactEntity
    {
        return $this->mainContact;
    }

    /**
     * @param PersonContactEntity|null $mainContact
     * @return self
     */
    public function setMainContact(?PersonContactEntity $mainContact): static
    {
        $this->mainContact = $mainContact;
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
     * @return self
     */
    public function setDocument(string $document): static
    {
        $this->document = $document;
        return $this;
    }

    /**
     * @return string
     */
    public function getSecondaryDocument(): string
    {
        return $this->secondaryDocument;
    }

    /**
     * @param string $secondaryDocument
     * @return self
     */
    public function setSecondaryDocument(string $secondaryDocument): static
    {
        $this->secondaryDocument = $secondaryDocument;
        return $this;
    }
}
