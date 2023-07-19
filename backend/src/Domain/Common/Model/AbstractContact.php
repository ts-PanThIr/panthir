<?php

namespace Panthir\Domain\Common\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity]
abstract class AbstractContact
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue('NONE')]
    protected string $id;

    #[ORM\Column]
    protected string $name;

    #[ORM\Column]
    protected string $phone;

    #[ORM\Column]
    protected string $email;

    #[ManyToOne(targetEntity: AbstractPerson::class, inversedBy: "contacts")]
    #[JoinColumn(name: "person_id", referencedColumnName: "id")]
    protected AbstractPerson $person;

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPerson(): AbstractPerson
    {
        return $this->person;
    }

    public function setPerson(AbstractPerson $person): self
    {
        $this->person = $person;
        return $this;
    }
}
