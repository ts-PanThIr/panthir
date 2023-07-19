<?php

namespace Panthir\Domain\Common\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity]
#[ORM\Table(name: 'person_contact')]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "discriminator", type: "string")]
abstract class AbstractContact
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column]
        #[ORM\GeneratedValue('NONE')]
        public readonly string $id,

        #[ORM\Column]
        public string          $name,

        #[ORM\Column]
        public string          $phone,

        #[ORM\Column]
        public string          $email,
    )
    {
    }
}
