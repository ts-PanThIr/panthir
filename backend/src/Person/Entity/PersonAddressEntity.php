<?php

namespace App\Person\Entity;

use App\Person\Repository\PersonAddressRepository;
use App\Shared\EntityTraits\AddressTrait;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PersonAddressRepository::class)]
#[ORM\Table(name: 'person_address')]
class PersonAddressEntity
{
    use AddressTrait;

    #[ManyToOne(targetEntity: PersonEntity::class, inversedBy: "addresses")]
    #[JoinColumn(name: "person_id", referencedColumnName: "id")]
    #[Groups(['person'])]
    private PersonEntity $person;

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
