<?php

namespace Panthir\Application\UseCase\Customer\Normalizer\DTO;

use Panthir\Application\Common\DTO\DTOInterface;
use Panthir\Domain\Customer\ValueObject\ContactType;
use Panthir\Infrastructure\CommonBundle\Exception\InvalidFieldException;
use Symfony\Component\Validator\Constraints as Assert;

class CustomerContactDTO implements DTOInterface
{
    private ?string $id = null;

    #[Assert\NotBlank]
    private string $name;

    #[Assert\NotBlank]
    private string $email;

    #[Assert\NotBlank]
    private string $phone;

    #[Assert\NotBlank]
    private string $type;

    private ?bool $delete = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): CustomerContactDTO
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
     * @return CustomerContactDTO
     */
    public function setName(string $name): CustomerContactDTO
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
     * @return CustomerContactDTO
     */
    public function setEmail(string $email): CustomerContactDTO
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
     * @return CustomerContactDTO
     */
    public function setPhone(string $phone): CustomerContactDTO
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /** @throws InvalidFieldException */
    public function setType(string $type): self
    {
        $enum = ContactType::tryFrom($type);
        if (!$enum) {
            throw new InvalidFieldException("Invalid type from customer's contact", 400);
        }

        $this->type = $enum->value;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getDelete(): ?bool
    {
        return $this->delete;
    }

    /**
     * @param bool|null $delete
     * @return $this
     */
    public function setDelete(?bool $delete): CustomerContactDTO
    {
        $this->delete = $delete;
        return $this;
    }
}
