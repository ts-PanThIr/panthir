<?php

namespace Panthir\Application\UseCase\Customer\POPO\Input;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Panthir\Application\Common\POPO\POPOInterface;
use Panthir\Application\Common\Transformer\AbstractPOPOTransformer;
use Panthir\Application\Common\Transformer\TransformFromRequestInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CustomerPOPO extends AbstractPOPOTransformer implements TransformFromRequestInterface, POPOInterface
{
    public function __construct(

        #[Assert\NotBlank]
        private readonly string               $name,

        #[Assert\NotBlank]
        private readonly string               $surname,

        #[Assert\NotBlank]
        private readonly string               $document,

        private readonly ?CustomerAddressPOPO $mainAddress = null,

        private readonly ?CustomerContactPOPO $mainContact = null,

        private readonly ?ArrayCollection     $addresses = null,

        private readonly ?ArrayCollection     $contacts = null,

        private readonly ?DateTime            $birthDate = null,

        private readonly ?string              $secondaryDocument = null,

        private readonly ?string              $additionalInformation = null
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

    public function getMainAddress(): CustomerAddressPOPO
    {
        return $this->mainAddress;
    }

    public function getMainContact(): CustomerContactPOPO
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
        return new CustomerPOPO(
            name: $object->getName(),
            surname: $object->getSurname(),
            document: $object->getDocument(),
            addresses: CustomerAddressPOPO::transformFromObjectsToCollection($object->getAddresses()),
            contacts: CustomerContactPOPO::transformFromObjectsToCollection($object->getContacts()),
            birthDate: $object->getRawBirthDate(),
            secondaryDocument: $object->getSecondaryDocument(),
            additionalInformation: $object->getAdditionalInformation()
        );
    }
}
