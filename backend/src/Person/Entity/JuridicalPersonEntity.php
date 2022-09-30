<?php

namespace App\Person\Entity;

use App\Person\Repository\JuridicalPersonRepository;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JuridicalPersonRepository::class)]
#[ORM\Table(name: 'person_juridical')]
class JuridicalPersonEntity
{
    use BlameableEntity;
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['person'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['person'])]
    private string $nickname;

    #[ORM\OneToOne(targetEntity: PersonEntity::class)]
    #[ORM\JoinColumn(name: "person_id", referencedColumnName: "id")]
    #[Groups(['person'])]
    private PersonEntity $person;

    #[ORM\OneToOne(targetEntity: PersonAddressEntity::class)]
    #[ORM\JoinColumn(name: "main_address_id", referencedColumnName: "id")]
    #[Groups(['person'])]
    private ?PersonAddressEntity $mainAddress = null;

    #[ORM\OneToOne(targetEntity: PersonContactEntity::class)]
    #[ORM\JoinColumn(name: "main_contact_id", referencedColumnName: "id")]
    #[Groups(['person'])]
    private ?PersonContactEntity $mainContact = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): static
    {
        $this->nickname = $nickname;
        return $this;
    }

    public function getMainAddress(): ?PersonAddressEntity
    {
        return $this->mainAddress;
    }

    public function setMainAddress(?PersonAddressEntity $mainAddress): static
    {
        $this->mainAddress = $mainAddress;
        return $this;
    }

    public function getMainContact(): ?PersonContactEntity
    {
        return $this->mainContact;
    }

    public function setMainContact(?PersonContactEntity $mainContact): static
    {
        $this->mainContact = $mainContact;
        return $this;
    }
}