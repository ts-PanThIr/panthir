<?php

namespace Panthir\Application\UseCase\Supplier\Normalizer\DTO;

use Panthir\Application\Common\DTO\DTOInterface;

class SupplierSearchDTO implements DTOInterface
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?int $limit = null,
        public readonly ?int $page = null,
    )
    {
    }
}
