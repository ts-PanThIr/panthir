<?php

namespace App\Person\Entity;

use DateTimeInterface;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'person_individual')]
class IndividualPersonEntity extends PersonEntity
{
    use BlameableEntity;
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['person'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['person'])]
    private ?DateTimeInterface $birthDate = null;

    #[ORM\Column]
    #[Groups(['person'])]
    private string $surname;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBirthDate(): String
    {
        if(empty($this->birthDate)) return '';
        return date_format($this->birthDate, 'd-m-Y');
    }

    public function setBirthDate(?DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;
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

    public function getPerson(): PersonEntity
    {
        return $this->person;
    }

    public function setPerson(PersonEntity $person): static
    {
        $this->person = $person;
        return $this;
    }

    public function getMainAddress(): ?PersonAddressEntity
    {
        return $this->mainAddress;
    }

    public function setMainAddress(?PersonAddressEntity $mainAddress): static
    {
        $this->mainAddress = $mainAddress;
        return $this;
    }

    public function getMainContact(): ?PersonContactEntity
    {
        return $this->mainContact;
    }

    public function setMainContact(?PersonContactEntity $mainContact): static
    {
        $this->mainContact = $mainContact;
        return $this;
    }
}