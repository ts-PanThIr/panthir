<?php

namespace Panthir\Domain\Common\Model;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Panthir\Domain\Customer\Model\Customer;
use Panthir\Domain\Supplier\Model\Supplier;

#[Entity]
#[ORM\Table(name: 'person')]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "discriminator", type: "string")]
#[ORM\DiscriminatorMap([
    'person' => AbstractPerson::class,
    'customer' => Customer::class,
    'supplier' => Supplier::class
])]
abstract class AbstractPerson
{
    use CountableTrait;
    use BlameableEntity;
    use TimestampableEntity;

    public function __construct(
        #[ORM\Id]
        #[ORM\Column]
        #[ORM\GeneratedValue('NONE')]
        public readonly string $id,

        #[ORM\Column]
        public string          $document,

        #[ORM\Column(name: 'name')]
        public string          $name,

        #[ORM\Column(nullable: true)]
        public ?string         $secondaryDocument = null,

        #[ORM\Column(type: Types::TEXT, nullable: true)]
        public ?string         $additionalInformation = null,
    )
    {
    }
}
