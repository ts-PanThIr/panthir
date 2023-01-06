<?php

namespace App\Person\DTO;

class PersonSearchDTO
{
    private ?bool $individual;

    /**
     * @return ?bool
     */
    public function IsIndividual(): ?bool
    {
        return $this->individual;
    }

    /**
     * @param ?bool $individual
     * @return self
     */
    public function setIndividual(?bool $individual): self
    {
        $this->individual = $individual;
        return $this;
    }
}
