<?php

namespace App\Financial\Entity;

use App\Financial\Repository\PaymentConditionFinancialRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentConditionFinancialRepository::class)]
#[ORM\Table(name: 'financial_payment_condition')]
class PaymentConditionFinancialEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['financial'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['financial'])]
    private string $name;

    #[ORM\Column]
    #[Groups(['financial'])]
    private int $maximumInstallmentQuantity;

    #[ORM\Column]
    #[Groups(['financial'])]
    private int $firstInterval;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return self
     */
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaximumInstallmentQuantity(): int
    {
        return $this->maximumInstallmentQuantity;
    }

    /**
     * @param int $maximumInstallmentQuantity
     * @return self
     */
    public function setMaximumInstallmentQuantity(int $maximumInstallmentQuantity): self
    {
        $this->maximumInstallmentQuantity = $maximumInstallmentQuantity;
        return $this;
    }

    /**
     * @return int
     */
    public function getFirstInterval(): int
    {
        return $this->firstInterval;
    }

    /**
     * @param int $firstInterval
     * @return self
     */
    public function setFirstInterval(int $firstInterval): self
    {
        $this->firstInterval = $firstInterval;
        return $this;
    }
}
