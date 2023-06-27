<?php

namespace Panthir\Application\UseCase\Customer\Normalizer\DTO;

use Panthir\Application\Common\DTO\DTOInterface;

class CustomerSearchDTO implements DTOInterface
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?int $limit = null,
        public readonly ?int $page = null,
    )
    {
    }
}