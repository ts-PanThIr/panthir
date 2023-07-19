<?php

namespace Panthir\Domain\Customer\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Panthir\Domain\Common\Model\AbstractContact;
use Panthir\Domain\Customer\ValueObject\ContactType;
use Panthir\Infrastructure\CommonBundle\Exception\InvalidFieldException;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\Table(name: 'person_contact')]
final class CustomerContact extends AbstractContact
{
    public function __construct(
        string                        $name,
        string                        $email,
        string                        $phone,
        public readonly UuidInterface $uuid,

        #[ORM\Column(name: 'type')]
        private string                $type,

        #[ManyToOne(targetEntity: Customer::class, inversedBy: "contacts")]
        #[JoinColumn(name: "person_id", referencedColumnName: "id")]
        public Customer               $person,
    )
    {
        parent::__construct(
            id: $uuid->__toString(),
            name: $name,
            phone: $phone,
            email: $email
        );
    }

    public function getType(): string
    {
        return $this->type;
    }

    /** @throws InvalidFieldException */
    public function setType(string $type): CustomerContact
    {
        $teste = array_column(ContactType::cases(), $type);
        if (!in_array(ContactType::cases(), array_column(ContactType::cases(), $type))) {
            throw new InvalidFieldException('Invalid type');
        }

        $this->type = $type;
        return $this;
    }
}
