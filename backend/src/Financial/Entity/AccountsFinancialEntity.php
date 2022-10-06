<?php

namespace App\Financial\Entity;

use App\Financial\Repository\AccountsFinancialRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AccountsFinancialRepository::class)]
#[ORM\Table(name: 'financial_account')]
class AccountsFinancialEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['financial'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['financial'])]
    private string $code;

    #[ORM\Column]
    #[Groups(['financial'])]
    private string $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}
