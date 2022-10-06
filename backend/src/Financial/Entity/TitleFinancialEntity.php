<?php
namespace App\Financial\Entity;

use App\Person\Entity\PersonEntity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

class TitleFinancialEntity
{
    use BlameableEntity;
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['financial'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['financial'])]
    private string $title;

    #[ORM\Column]
    #[Groups(['financial'])]
    private string $type;

    #[ORM\Column]
    #[Groups(['financial'])]
    private ?string $description;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['financial'])]
    private \DateTime $entryAt;

    #[ManyToOne(targetEntity: PersonEntity::class)]
    #[JoinColumn(name: "person_id", referencedColumnName: "id")]
    #[Groups(['financial'])]
    private PersonEntity $person;
}