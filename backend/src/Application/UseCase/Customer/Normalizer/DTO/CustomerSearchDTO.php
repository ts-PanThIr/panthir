<?php

namespace Panthir\Application\UseCase\Customer\Normalizer\DTO;

use Panthir\Application\Common\DTO\DTOInterface;

class CustomerSearchDTO implements DTOInterface
{
    public function __construct(
        private ?string $id = null,
    )
    {
    }

    public function getId(): ?string
    {
        return $this->id;
    }
}