<?php

namespace App\Person\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Table(name: 'person_individual_portugal')]
class PortugalIndividualPerson
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
    private string $nif;

    #[ORM\Column]
    #[Groups(['person'])]
    private string $niss;

    #[ORM\OneToOne(targetEntity: IndividualPersonEntity::class)]
    #[ORM\JoinColumn(name: "individual_person_id", referencedColumnName: "id")]
    #[Groups(['person'])]
    private PersonEntity $person;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNif(): string
    {
        return $this->nif;
    }

    public function setNif(string $nif): static
    {
        $this->nif = $nif;
        return $this;
    }

    public function getNiss(): string
    {
        return $this->niss;
    }

    public function setNiss(string $niss): static
    {
        $this->niss = $niss;
        return $this;
    }
}