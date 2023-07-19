<?php

namespace Panthir\Application\UseCase\Supplier\Normalizer\DTO;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Panthir\Application\Common\DTO\DTOInterface;
use Symfony\Component\Validator\Constraints as Assert;

class SupplierCreateDTO implements DTOInterface
{
    public function __construct(

        #[Assert\NotBlank]
        public readonly string              $name,

        #[Assert\NotBlank]
        public readonly string              $nickname,

        #[Assert\NotBlank]
        public readonly string              $document,

        public readonly Collection          $addresses = new ArrayCollection(),

        public readonly Collection          $contacts = new ArrayCollection(),

        public readonly ?string             $secondaryDocument = null,

        public readonly ?string             $additionalInformation = null
    )
    {
    }
}
