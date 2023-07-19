<?php

namespace Panthir\Domain\Common\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Table(name: 'person')]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "discriminator", type: "string")]
//#[ORM\DiscriminatorMap(["person" => "Person"])] 
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
