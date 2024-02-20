<?php

namespace Panthir\Application\UseCase\Product\Normalizer\DTO;

use Panthir\Application\Common\DTO\DTOInterface;

class ProductSearchDTO implements DTOInterface
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?int $limit = null,
        public readonly ?int $page = null,
    )
    {
    }
}
