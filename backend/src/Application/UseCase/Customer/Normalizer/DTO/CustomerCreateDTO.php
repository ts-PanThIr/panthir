<?php

namespace Panthir\Application\UseCase\Customer\Normalizer\DTO;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Panthir\Application\Common\DTO\DTOInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CustomerCreateDTO implements DTOInterface
{
    public function __construct(

        #[Assert\NotBlank]
        private readonly string              $name,

        #[Assert\NotBlank]
        private readonly string              $surname,

        #[Assert\NotBlank]
        private readonly string              $document,

        private readonly ?CustomerAddressDTO $mainAddress = null,

        private readonly ?CustomerContactDTO $mainContact = null,

        private readonly ?ArrayCollection    $addresses = null,

        private readonly ?ArrayCollection    $contacts = null,

        private readonly ?DateTime           $birthDate = null,

        private readonly ?string             $secondaryDocument = null,

        private readonly ?string             $additionalInformation = null
    )
    {
    }

    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAdditionalInformation(): ?string
    {
        return $this->additionalInformation;
    }

    public function getMainAddress(): CustomerAddressDTO
    {
        return $this->mainAddress;
    }

    public function getMainContact(): CustomerContactDTO
    {
        return $this->mainContact;
    }

    public function getAddresses(): ?ArrayCollection
    {
        return $this->addresses;
    }

    public function getContacts(): ?ArrayCollection
    {
        return $this->contacts;
    }

    public function getRawBirthDate(): ?DateTime
    {
        return $this->birthDate;
    }

    public function getBirthDate(): string
    {
        if (empty($this->birthDate)) {
            return '';
        }
        return date_format($this->birthDate, 'd/m/Y');
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getDocument(): string
    {
        return $this->document;
    }

    public function getSecondaryDocument(): ?string
    {
        return $this->secondaryDocument;
    }

    public static function transformFromRequest(Request $object): self
    {
        return new CustomerCreateDTO(
            name: $object->getName(),
            surname: $object->getSurname(),
            document: $object->getDocument(),
            addresses: CustomerAddressDTO::transformFromObjectsToCollection($object->getAddresses()),
            contacts: CustomerContactDTO::transformFromObjectsToCollection($object->getContacts()),
            birthDate: $object->getRawBirthDate(),
            secondaryDocument: $object->getSecondaryDocument(),
            additionalInformation: $object->getAdditionalInformation()
        );
    }
}
