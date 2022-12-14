<?php

namespace App\Person\Entity;

use App\Person\Repository\PersonContactRepository;
use App\Shared\EntityTraits\ContactTrait;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PersonContactRepository::class)]
#[ORM\Table(name: 'person_contact')]
class PersonContactEntity
{
    use ContactTrait;

    #[ORM\Column]
    #[Groups(['person'])]
    private bool $individual = true;

    #[ManyToOne(targetEntity: PersonEntity::class, inversedBy: "contacts")]
    #[JoinColumn(name: "person_id", referencedColumnName: "id")]
    #[Groups(['person'])]
    private PersonEntity $person;

    /**
     * @return bool
     */
    public function isIndividual(): bool
    {
        return $this->individual;
    }

    /**
     * @param bool $individual
     * @return self
     */
    public function setIndividual(bool $individual): self
    {
        $this->individual = $individual;
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
    public function setPerson(PersonEntity $person): self
    {
        $this->person = $person;
        return $this;
    }
}
