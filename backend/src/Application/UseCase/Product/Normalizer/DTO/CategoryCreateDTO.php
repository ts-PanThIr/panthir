<?php

namespace Panthir\Application\UseCase\Product\Normalizer\DTO;

use Panthir\Application\Common\DTO\DTOInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CategoryCreateDTO implements DTOInterface
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $name,

        #[Assert\NotBlank]
        public readonly bool $isLastLevel,
        public readonly ?string $parentId = null,
    )
    {
    }
}
