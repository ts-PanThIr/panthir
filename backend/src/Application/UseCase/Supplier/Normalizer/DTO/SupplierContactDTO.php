<?php

namespace Panthir\Application\UseCase\Supplier\Normalizer\DTO;

use Panthir\Application\Common\DTO\DTOInterface;
use Panthir\Domain\Supplier\ValueObject\ContactType;
use Panthir\Infrastructure\CommonBundle\Exception\InvalidFieldException;
use Symfony\Component\Validator\Constraints as Assert;

class SupplierContactDTO implements DTOInterface
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $name,

        #[Assert\NotBlank]
        public readonly string $email,

        #[Assert\NotBlank]
        public readonly string $phone,

        #[Assert\NotBlank]
        private string $type,
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
        if (!in_array(ContactType::cases(), array_column(ContactType::cases(), $type))) {
            throw new InvalidFieldException('Invalid type');
        }

        $this->type = $type;
        return $this;
    }
}
