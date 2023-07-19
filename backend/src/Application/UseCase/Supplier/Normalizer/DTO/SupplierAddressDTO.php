<?php

namespace Panthir\Application\UseCase\Supplier\Normalizer\DTO;

use Panthir\Application\Common\DTO\DTOInterface;
use Panthir\Domain\Supplier\ValueObject\AddressType;
use Panthir\Infrastructure\CommonBundle\Exception\InvalidFieldException;
use Symfony\Component\Validator\Constraints as Assert;

class SupplierAddressDTO implements DTOInterface
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string  $name,

        #[Assert\NotBlank]
        public readonly string  $country,

        #[Assert\NotBlank]
        public readonly string  $district,

        #[Assert\NotBlank]
        public readonly string  $city,

        #[Assert\NotBlank]
        public readonly string  $address,

        #[Assert\NotBlank]
        public readonly string  $number,

        #[Assert\NotBlank]
        public readonly string  $zip,

        #[Assert\NotBlank]
        private string          $type,

        public readonly ?string $addressComplement = null,
    )
    {
    }

    public function getType(): string
    {
        return $this->type;
    }

    /** @throws InvalidFieldException */
    public function setType(string $type): self
    {
        if (!in_array(AddressType::cases(), array_column(AddressType::cases(), $type))) {
            throw new InvalidFieldException('Invalid type');
        }

        $this->type = $type;
        return $this;
    }
}
