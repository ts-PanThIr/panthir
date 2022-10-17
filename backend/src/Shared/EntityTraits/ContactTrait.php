<?php

namespace App\Shared\EntityTraits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait ContactTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['person'])]
    private ?int $id = null;
    
    #[ORM\Column]
    #[Groups(['person'])]
    private string $contactName;

    #[ORM\Column]
    #[Groups(['person'])]
    private string $phone;

    #[ORM\Column]
    #[Groups(['person'])]
    private string $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContactName(): string
    {
        return $this->contactName;
    }

    public function setContactName($contactName): self
    {
        $this->contactName = $contactName;
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
}