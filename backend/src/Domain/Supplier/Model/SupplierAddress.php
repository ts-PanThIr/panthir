<?php

namespace Panthir\Domain\Supplier\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Panthir\Domain\Common\Model\AbstractAddress;
use Panthir\Domain\Supplier\ValueObject\AddressType;
use Panthir\Infrastructure\CommonBundle\Exception\InvalidFieldException;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\Table(name: 'person_address')]
final class SupplierAddress extends AbstractAddress
{
    public function __construct(
        string                        $name,
        string                        $address,
        string                        $addressComplement,
        string                        $city,
        string                        $country,
        string                        $district,
        string                        $number,
        string                        $zip,
        public readonly UuidInterface $uuid,

        #[ORM\Column(name: 'type')]
        private string                $type,

        #[ManyToOne(targetEntity: Supplier::class, inversedBy: "addresses")]
        #[JoinColumn(name: "person_id", referencedColumnName: "id")]
        public Supplier               $person,
    )
    {
        parent::__construct(
            id: $uuid->__toString(),
            name: $name,
            country: $country,
            district: $district,
            city: $city,
            address: $address,
            number: $number,
            zip: $zip,
            addressComplement: $addressComplement
        );
    }

    public function getType(): string
    {
        return $this->type;
    }

    /** @throws InvalidFieldException */
    public function setType(string $type): self
    {
        if (!in_array(AddressType::cases(), array_column(AddressType::cases(), $type))) {
            throw new InvalidFieldException('Invalid type');
        }

        $this->type = $type;
        return $this;
    }
}
