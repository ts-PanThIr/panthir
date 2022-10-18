<?php

namespace App\Person\DTO;

class PersonContactDTO
{
    private int $id;

    private string $name;

    private string $email;

    private string $phone;

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
}
