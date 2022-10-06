<?php

namespace App\Financial\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Serializer\Annotation\Groups;

class InstallmentFinancialEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['financial'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['financial'])]
    private int $number;

    #[ORM\Column]
    #[Groups(['financial'])]
    private float $value;

    #[ORM\Column]
    #[Groups(['financial'])]
    private ?float $fees;

    #[ORM\Column]
    #[Groups(['financial'])]
    private ?float $fine;

    #[ORM\Column]
    #[Groups(['financial'])]
    private ?float $extra;

    #[ORM\Column]
    #[Groups(['financial'])]
    private ?float $discount;

    #[ORM\Column]
    #[Groups(['financial'])]
    private float $total;

    #[ORM\Column]
    #[Groups(['financial'])]
    private ?float $paid;

    #[ManyToOne(targetEntity: TitleFinancialEntity::class)]
    #[JoinColumn(name: "title_financial_id", referencedColumnName: "id")]
    #[Groups(['financial'])]
    private TitleFinancialEntity $titleFinancial;
}