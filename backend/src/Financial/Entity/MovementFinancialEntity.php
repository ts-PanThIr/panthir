<?php

namespace App\Financial\Entity;

use App\Financial\Repository\MovementFinancialRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MovementFinancialRepository::class)]
#[ORM\Table(name: 'financial_movement')]
class MovementFinancialEntity
{
    use BlameableEntity;
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['financial'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['financial'])]
    private float $value;

    #[ORM\Column]
    #[Groups(['financial'])]
    private ?string $description;

    #[ManyToOne(targetEntity: InstallmentFinancialEntity::class)]
    #[JoinColumn(name: "installment_financial_id", referencedColumnName: "id")]
    #[Groups(['financial'])]
    private InstallmentFinancialEntity $installment;

    #[ManyToOne(targetEntity: AccountsFinancialEntity::class)]
    #[JoinColumn(name: "account_financial_id", referencedColumnName: "id")]
    #[Groups(['financial'])]
    private AccountsFinancialEntity $account;

    #[ORM\OneToOne(targetEntity: MovementFinancialEntity::class)]
    #[Groups(['financial'])]
    private MovementFinancialEntity $counterpart;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;
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

    public function getInstallment(): InstallmentFinancialEntity
    {
        return $this->installment;
    }

    public function setInstallment(InstallmentFinancialEntity $installment): self
    {
        $this->installment = $installment;
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

    public function getCounterpart(): MovementFinancialEntity
    {
        return $this->counterpart;
    }

    public function setCounterpart(MovementFinancialEntity $counterpart): self
    {
        $this->counterpart = $counterpart;
        return $this;
    }
}
