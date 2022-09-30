<?php

namespace App\Person\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Table(name: 'person_individual_brasil')]
class BrasilIndividualPerson
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
    private string $cpf;

    #[ORM\Column]
    #[Groups(['person'])]
    private string $rg;

    #[ORM\OneToOne(targetEntity: IndividualPersonEntity::class)]
    #[ORM\JoinColumn(name: "individual_person_id", referencedColumnName: "id")]
    #[Groups(['person'])]
    private PersonEntity $person;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): static
    {
        $this->cpf = $cpf;
        return $this;
    }

    public function getRg(): string
    {
        return $this->rg;
    }

    public function setRg(string $rg): static
    {
        $this->rg = $rg;
        return $this;
    }
}