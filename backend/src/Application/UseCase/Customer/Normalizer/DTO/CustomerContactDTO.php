<?php

namespace Panthir\Application\UseCase\Customer\Normalizer\DTO;

use Panthir\Application\Common\DTO\DTOInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CustomerContactDTO implements DTOInterface
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $name,

        #[Assert\NotBlank]
        public readonly string $email,

        #[Assert\NotBlank]
        public readonly string $phone
    )
    {
    }
}
