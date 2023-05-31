<?php

namespace App\Shared\DTO;

use App\Domain\Person\Entity\PersonContactEntity;
use App\Domain\Person\Entity\PersonEntity;
use App\Shared\Transformer\AbstractPOPOTransformer;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class PersonContactPOPO extends AbstractPOPOTransformer
{
    #[Groups(['person'])]
    private ?int $id = null;

    #[Groups(['person'])]
    #[Assert\NotBlank]
    private string $name;

    #[Groups(['person'])]
    #[Assert\NotBlank]
    private string $email;

    #[Groups(['person'])]
    #[Assert\NotBlank]
    private string $phone;

    #[Assert\NotBlank]
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
     * @return PersonContactPOPO
     */
    public function setId(int $id): PersonContactPOPO
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
     * @return PersonContactPOPO
     */
    public function setName(string $name): PersonContactPOPO
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
     * @return PersonContactPOPO
     */
    public function setEmail(string $email): PersonContactPOPO
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
     * @return PersonContactPOPO
     */
    public function setPhone(string $phone): PersonContactPOPO
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
     * @return PersonContactPOPO
     */
    public static function transformFromObject(object $object): PersonContactPOPO
    {
        $dto = new PersonContactPOPO();
        return $dto
            ->setName($object->getName())
            ->setId($object->getId())
            ->setEmail($object->getEmail())
            ->setPhone($object->getPhone())
        ;
    }
}
