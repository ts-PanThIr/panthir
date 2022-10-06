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

class MovementFinancialEntity
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
    private float $value;

    #[ORM\Column]
    #[Groups(['financial'])]
    private ?string $description;

    #[ManyToOne(targetEntity: InstallmentFinancialEntity::class)]
    #[JoinColumn(name: "installment_financial_id", referencedColumnName: "id")]
    #[Groups(['financial'])]
    private InstallmentFinancialEntity $installment;
}