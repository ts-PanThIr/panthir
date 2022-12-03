<?php

namespace App\Financial\DTO;

use App\Financial\Entity\PaymentConditionFinancialEntity;
use App\Shared\Transformer\AbstractDTOTransformer;
use Symfony\Component\Serializer\Annotation\Groups;

class FinancialPaymentConditionDTO extends AbstractDTOTransformer
{
    #[Groups(['financial'])]
    private ?int $id = null;

    #[Groups(['financial'])]
    private string $name;

    #[Groups(['financial'])]
    private int $maximumInstallmentQuantity;

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

    /**
     * @param PaymentConditionFinancialEntity $object
     * @return self
     */
    public static function transformFromObject(object $object): self
    {
        $dto = new FinancialPaymentConditionDTO();
        $dto->setFirstInterval($object->getFirstInterval())
            ->setName($object->getName())
            ->setId($object->getId())
            ->setMaximumInstallmentQuantity($object->getMaximumInstallmentQuantity())
        ;
        return $dto;
    }
}
