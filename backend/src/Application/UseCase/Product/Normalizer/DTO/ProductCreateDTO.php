<?php

namespace Panthir\Application\UseCase\Product\Normalizer\DTO;

use Panthir\Application\Common\DTO\DTOInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ProductCreateDTO implements DTOInterface
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $name,

        #[Assert\NotBlank]
        public readonly string $brand,

        #[Assert\NotBlank]
        public readonly string $categoryId,

        #[Assert\NotBlank]
        public readonly float $value,
    )
    {
    }
}
