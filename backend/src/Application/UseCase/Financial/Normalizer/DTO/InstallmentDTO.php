<?php

namespace Panthir\Application\UseCase\Financial\Normalizer\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class InstallmentDTO
{
    #[Assert\NotBlank]
    private float $value;

    #[Assert\NotBlank]
    private float $fees;

    #[Assert\NotBlank]
    private float $fine;

    #[Assert\NotBlank]
    private float $discount;

    #[Assert\NotBlank]
    private \DateTime $date;

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     * @return InstallmentDTO
     */
    public function setValue(float $value): InstallmentDTO
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getFees(): float
    {
        return $this->fees;
    }

    /**
     * @param float $fees
     * @return InstallmentDTO
     */
    public function setFees(float $fees): InstallmentDTO
    {
        $this->fees = $fees;
        return $this;
    }

    /**
     * @return float
     */
    public function getFine(): float
    {
        return $this->fine;
    }

    /**
     * @param float $fine
     * @return InstallmentDTO
     */
    public function setFine(float $fine): InstallmentDTO
    {
        $this->fine = $fine;
        return $this;
    }

    /**
     * @return float
     */
    public function getDiscount(): float
    {
        return $this->discount;
    }

    /**
     * @param float $discount
     * @return InstallmentDTO
     */
    public function setDiscount(float $discount): InstallmentDTO
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return InstallmentDTO
     */
    public function setDate(\DateTime $date): InstallmentDTO
    {
        $this->date = $date;
        return $this;
    }
}