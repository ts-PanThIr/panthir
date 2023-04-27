<?php

namespace App\Person\DTO;

use App\Person\Entity\PersonContactEntity;
use App\Person\Entity\PersonEntity;
use App\Shared\Transformer\AbstractDTOTransformer;
use Symfony\Component\Serializer\Annotation\Groups;

class PersonContactDTO extends AbstractDTOTransformer
{
    #[Groups(['person'])]
    private ?int $id = null;

    #[Groups(['person'])]
    private string $name;

    #[Groups(['person'])]
    private string $email;

    #[Groups(['person'])]
    private string $phone;

    private PersonEntity $personEntity;

    /**
     * @return ?int
     */
    public function getId(): ?int
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
     * @param PersonContactEntity $object
     * @return PersonContactDTO
     */
    public static function transformFromObject(object $object): PersonContactDTO
    {
        $dto = new PersonContactDTO();
        return $dto
            ->setName($object->getName())
            ->setId($object->getId())
            ->setEmail($object->getEmail())
            ->setPhone($object->getPhone())
        ;
    }
}
