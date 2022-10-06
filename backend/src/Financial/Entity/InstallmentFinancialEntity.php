<?php

namespace App\Financial\Entity;

use App\Financial\Repository\InstallmentFinancialRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: InstallmentFinancialRepository::class)]
#[ORM\Table(name: 'financial_installment')]
class InstallmentFinancialEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['financial'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['financial'])]
    private int $number;

    #[ORM\Column]
    #[Groups(['financial'])]
    private float $value;

    #[ORM\Column]
    #[Groups(['financial'])]
    private ?float $fees;

    #[ORM\Column]
    #[Groups(['financial'])]
    private ?float $fine;

    #[ORM\Column]
    #[Groups(['financial'])]
    private ?float $extra;

    #[ORM\Column]
    #[Groups(['financial'])]
    private ?float $discount;

    #[ORM\Column]
    #[Groups(['financial'])]
    private float $total;

    #[ORM\Column]
    #[Groups(['financial'])]
    private ?float $paid;

    #[ManyToOne(targetEntity: TitleFinancialEntity::class)]
    #[JoinColumn(name: "title_financial_id", referencedColumnName: "id")]
    #[Groups(['financial'])]
    private TitleFinancialEntity $titleFinancial;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;
        return $this;
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

    public function getFees(): ?float
    {
        return $this->fees;
    }

    public function setFees(?float $fees): self
    {
        $this->fees = $fees;
        return $this;
    }

    public function getFine(): ?float
    {
        return $this->fine;
    }

    public function setFine(?float $fine): self
    {
        $this->fine = $fine;
        return $this;
    }

    public function getExtra(): ?float
    {
        return $this->extra;
    }

    public function setExtra(?float $extra): self
    {
        $this->extra = $extra;
        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(?float $discount): self
    {
        $this->discount = $discount;
        return $this;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;
        return $this;
    }

    public function getPaid(): ?float
    {
        return $this->paid;
    }

    public function setPaid(?float $paid): self
    {
        $this->paid = $paid;
        return $this;
    }

    public function getTitleFinancial(): TitleFinancialEntity
    {
        return $this->titleFinancial;
    }

    public function setTitleFinancial(TitleFinancialEntity $titleFinancial): self
    {
        $this->titleFinancial = $titleFinancial;
        return $this;
    }
}
