<?php

namespace Panthir\Application\UseCase\Customer\Normalizer\DTO;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Panthir\Application\Common\DTO\DTOInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CustomerCreateDTO implements DTOInterface
{
    public function __construct(

        #[Assert\NotBlank]
        public readonly string          $name,

        #[Assert\NotBlank]
        public readonly string          $surname,

        #[Assert\NotBlank]
        public readonly string          $document,

        public readonly ArrayCollection $addresses = new ArrayCollection(),

        public readonly ArrayCollection $contacts = new ArrayCollection(),

        private readonly ?DateTime      $birthDate = null,

        public readonly ?string         $secondaryDocument = null,

        public readonly ?string         $additionalInformation = null
    )
    {
    }

    public function getBirthDate(): string
    {
        if (empty($this->birthDate)) {
            return '';
        }
        return date_format($this->birthDate, 'd/m/Y');
    }

    public function getRawBirthDate(): ?DateTime
    {
        return $this->birthDate;
    }
}
