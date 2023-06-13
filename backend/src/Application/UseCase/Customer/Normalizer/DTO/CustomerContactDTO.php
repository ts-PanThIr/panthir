<?php

namespace Panthir\Application\UseCase\Customer\Normalizer\DTO;

use Panthir\Application\Common\DTO\DTOInterface;
use Panthir\Domain\Customer\Model\CustomerContact;
use Symfony\Component\Validator\Constraints as Assert;

class CustomerContactDTO implements DTOInterface
{
    public function __construct(
        #[Assert\NotBlank]
        private readonly string $name,

        #[Assert\NotBlank]
        private readonly string $email,

        #[Assert\NotBlank]
        private readonly string $phone
    )
    {
    }

    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param CustomerContact $object
     * @return CustomerContactDTO
     */
    public static function transformFromObject(object $object): CustomerContactDTO
    {
        return new CustomerContactDTO(
            name: $object->getName(),
            email: $object->getEmail(),
            phone: $object->getPhone()
        );
    }
}
