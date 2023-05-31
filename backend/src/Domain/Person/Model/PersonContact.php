<?php

namespace Panthir\Domain\Person\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Panthir\Domain\Common\Model\ContactTrait;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: 'person_contact')]
class PersonContact
{
    use ContactTrait;

    #[ManyToOne(targetEntity: Person::class, inversedBy: "contacts")]
    #[JoinColumn(name: "person_id", referencedColumnName: "id")]
    #[Groups(['person'])]
    private Person $person;

    public function getPerson(): Person
    {
        return $this->person;
    }

    public function setPerson(Person $person): self
    {
        $this->person = $person;
        return $this;
    }
}
