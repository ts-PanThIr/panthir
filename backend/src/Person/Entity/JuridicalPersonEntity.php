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

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     * @return self
     */
    public function setNickname(string $nickname): static
    {
        $this->nickname = $nickname;
        return $this;
    }

    /**
     * @return PersonAddressEntity|null
     */
    public function getMainAddress(): ?PersonAddressEntity
    {
        return $this->mainAddress;
    }

    /**
     * @param PersonAddressEntity|null $mainAddress
     * @return self
     */
    public function setMainAddress(?PersonAddressEntity $mainAddress): static
    {
        $this->mainAddress = $mainAddress;
        return $this;
    }

    /**
     * @return PersonContactEntity|null
     */
    public function getMainContact(): ?PersonContactEntity
    {
        return $this->mainContact;
    }

    /**
     * @param PersonContactEntity|null $mainContact
     * @return self
     */
    public function setMainContact(?PersonContactEntity $mainContact): static
    {
        $this->mainContact = $mainContact;
        return $this;
    }

    /**
     * @return PersonEntity
     */
    public function getPerson(): PersonEntity
    {
        return $this->person;
    }

    /**
     * @param PersonEntity $person
     * @return self
     */
    public function setPerson(PersonEntity $person): static
    {
        $this->person = $person;
        return $this;
    }
}
