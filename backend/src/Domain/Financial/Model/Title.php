<?php

namespace App\Financial\Entity;

use App\Financial\Repository\TitleFinancialRepository;
use App\Person\Entity\PersonEntity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: TitleFinancialRepository::class)]
#[ORM\Table(name: 'financial_title')]
class Title
{
    use BlameableEntity;
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue('NONE')]
    private ?int $id = null;

    #[ORM\Column]
    private string $title;

    #[ORM\Column]
    private string $type;

    #[ORM\Column]
    private ?string $description;

    #[ORM\Column]
    private ?bool $isIndividualPerson;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTime $entryAt;

    #[ManyToOne(targetEntity: PersonEntity::class)]
    #[JoinColumn(name: "person_id", referencedColumnName: "id")]
    private PersonEntity $person;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getEntryAt(): \DateTime
    {
        return $this->entryAt;
    }

    public function setEntryAt(\DateTime $entryAt): self
    {
        $this->entryAt = $entryAt;
        return $this;
    }

    function getPerson(): PersonEntity
    {
        return $this->person;
    }

    public function setPerson(PersonEntity $person): self
    {
        $this->person = $person;
        return $this;
    }

    public function getIsIndividualPerson(): ?bool
    {
        return $this->isIndividualPerson;
    }

    public function setIsIndividualPerson(?bool $isIndividualPerson): self
    {
        $this->isIndividualPerson = $isIndividualPerson;
        return $this;
    }

    public function getAccount(): AccountsFinancialEntity
    {
        return $this->account;
    }

    public function setAccount(AccountsFinancialEntity $account): self
    {
        $this->account = $account;
        return $this;
    }

    public function getCounterpartAccount(): AccountsFinancialEntity
    {
        return $this->counterpartAccount;
    }

    public function setCounterpartAccount(AccountsFinancialEntity $counterpartAccount): self
    {
        $this->counterpartAccount = $counterpartAccount;
        return $this;
    }
}