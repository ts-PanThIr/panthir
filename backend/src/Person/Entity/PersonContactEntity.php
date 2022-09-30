<?php

namespace App\Person\Entity;

use App\Person\Repository\PersonContactRepository;
use App\Shared\EntityTraits\ContactTrait;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PersonContactRepository::class)]
#[ORM\Table(name: 'person_contact')]
class PersonContactEntity
{
    use ContactTrait;

    #[ManyToOne(targetEntity: IndividualPersonEntity::class)]
    #[JoinColumn(name: "individual_person_id", referencedColumnName: "id")]
    #[Groups(['person'])]
    private IndividualPersonEntity $individualPerson;

    #[ManyToOne(targetEntity: JuridicalPersonEntity::class)]
    #[JoinColumn(name: "juridical_person_id", referencedColumnName: "id")]
    #[Groups(['person'])]
    private JuridicalPersonEntity $juridicalPerson;
}