<?php

namespace Panthir\Domain\Common\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity]
#[ORM\Table(name: 'person_address')]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "discriminator", type: "string")]
abstract class AbstractAddress
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column]
        #[ORM\GeneratedValue('NONE')]
        public readonly string $id,

        #[ORM\Column]
        public string          $name,

        #[ORM\Column]
        public string          $country,

        #[ORM\Column]
        public string          $district,

        #[ORM\Column]
        public string          $city,

        #[ORM\Column]
        public string          $address,

        #[ORM\Column]
        public string          $number,

        #[ORM\Column]
        public string          $zip,

        #[ORM\Column(nullable: true)]
        public ?string         $addressComplement,
    )
    {
    }
}
