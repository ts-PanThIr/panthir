<?php

namespace App\Person\Entity;

use App\Shared\EntityTraits\AddressTrait;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Table(name: 'person_address')]
class PersonAddressEntity
{
    use AddressTrait;

    #[ManyToOne(targetEntity: IndividualPersonEntity::class)]
    #[JoinColumn(name: "individual_person_id", referencedColumnName: "id")]
    #[Groups(['person'])]
    private IndividualPersonEntity $individualPerson;

    #[ManyToOne(targetEntity: JuridicalPersonEntity::class)]
    #[JoinColumn(name: "juridical_person_id", referencedColumnName: "id")]
    #[Groups(['person'])]
    private JuridicalPersonEntity $juridicalPerson;
}