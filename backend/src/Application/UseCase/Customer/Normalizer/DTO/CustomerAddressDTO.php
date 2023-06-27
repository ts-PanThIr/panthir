<?php

namespace Panthir\Application\UseCase\Customer\Normalizer\DTO;

use Panthir\Application\Common\DTO\DTOInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CustomerAddressDTO implements DTOInterface
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

        public readonly ?string $addressComplement = null,
    )
    {
    }
}
