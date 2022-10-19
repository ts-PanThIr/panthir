<?php

namespace App\Person\DTO;

use App\Person\Entity\PersonEntity;

class PersonContactDTO
{
    private int $id;

    private string $name;

    private string $email;

    private string $phone;

    private PersonEntity $personEntity;

    private bool $individual;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return PersonContactDTO
     */
    public function setId(int $id): PersonContactDTO
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
     * @return PersonContactDTO
     */
    public function setName(string $name): PersonContactDTO
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return PersonContactDTO
     */
    public function setEmail(string $email): PersonContactDTO
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return PersonContactDTO
     */
    public function setPhone(string $phone): PersonContactDTO
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return PersonEntity
     */
    public function getPersonEntity(): PersonEntity
    {
        return $this->personEntity;
    }

    /**
     * @param PersonEntity $personEntity
     * @return self
     */
    public function setPersonEntity(PersonEntity $personEntity): self
    {
        $this->personEntity = $personEntity;
        return $this;
    }

    /**
     * @return bool
     */
    public function IsIndividual(): bool
    {
        return $this->individual;
    }

    /**
     * @param bool $individual
     * @return self
     */
    public function setIndividual(bool $individual): self
    {
        $this->individual = $individual;
        return $this;
    }
}
