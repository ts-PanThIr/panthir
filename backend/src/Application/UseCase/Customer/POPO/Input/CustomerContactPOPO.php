<?php

namespace Panthir\Application\UseCase\Customer\POPO\Input;

use Panthir\Application\Common\Transformer\AbstractPOPOTransformer;
use Panthir\Domain\Customer\Model\CustomerContact;
use Symfony\Component\Validator\Constraints as Assert;

class CustomerContactPOPO extends AbstractPOPOTransformer
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
     * @return CustomerContactPOPO
     */
    public static function transformFromObject(object $object): CustomerContactPOPO
    {
        return new CustomerContactPOPO(
            name: $object->getName(),
            email: $object->getEmail(),
            phone: $object->getPhone()
        );
    }
}
