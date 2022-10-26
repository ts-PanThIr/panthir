<?php

namespace App\Person\Entity;

use App\Entity\Company\Company;
use App\Entity\Vault\Vault;
use App\Person\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
#[ORM\Table(name: 'person')]
class PersonEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['person'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['person'])]
    private string $name;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['person'])]
    private ?string $additionalInformation = null;

    #[ORM\OneToMany(mappedBy: "person", targetEntity: PersonAddressEntity::class, cascade: ["persist"])]
    #[Groups(['person'])]
    private Collection $addresses;

    #[ORM\OneToMany(mappedBy: "person", targetEntity: PersonContactEntity::class, cascade: ["persist"])]
    #[Groups(['person'])]
    private Collection $contacts;

    #[OneToOne(mappedBy: 'person', targetEntity: IndividualPersonEntity::class)]
    #[Groups(['person'])]
    private ?IndividualPersonEntity $individualPerson = null;

    #[OneToOne(mappedBy: 'person', targetEntity: JuridicalPersonEntity::class)]
    #[Groups(['person'])]
    private ?JuridicalPersonEntity $juridicalPerson = null;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->contacts = new ArrayCollection();
    }

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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAdditionalInformation(): ?string
    {
        return $this->additionalInformation;
    }

    /**
     * @param string|null $additionalInformation
     * @return self
     */
    public function setAdditionalInformation(?string $additionalInformation): static
    {
        $this->additionalInformation = $additionalInformation;
        return $this;
    }

    /**
     * @param PersonAddressEntity $address
     * @return self
     */
    public function addAddresses(PersonAddressEntity $address): self
    {
        if (!$this->addresses->contains($address)) {
            $address->setPerson($this);

            $this->addresses->add($address);
        }

        return $this;
    }

    /**
     * @param PersonAddressEntity $address
     * @return self
     */
    public function removeAddresses(PersonAddressEntity $address): self
    {
        if ($this->addresses->contains($address)) {
            $address->setPerson(null);

            $this->addresses->removeElement($address);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    /**
     * @param ArrayCollection $address
     * @return self
     */
    public function setAddresses(ArrayCollection $address): self
    {
        $this->addresses = $address;

        return $this;
    }

    /**
     * @param PersonContactEntity $contact
     * @return self
     */
    public function addContacts(PersonContactEntity $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $contact->setPerson($this);

            $this->contacts->add($contact);
        }

        return $this;
    }

    /**
     * @param PersonContactEntity $contact
     * @return self
     */
    public function removeContacts(PersonContactEntity $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $contact->setPerson(null);

            $this->contacts->removeElement($contact);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    /**
     * @param ArrayCollection $contact
     * @return self
     */
    public function setContacts(ArrayCollection $contact): self
    {
        $this->contacts = $contact;

        return $this;
    }

    /**
     * @return IndividualPersonEntity|null
     */
    public function getIndividualPerson(): ?IndividualPersonEntity
    {
        return $this->individualPerson;
    }

    /**
     * @param IndividualPersonEntity|null $individualPerson
     * @return self
     */
    public function setIndividualPerson(?IndividualPersonEntity $individualPerson): self
    {
        $this->individualPerson = $individualPerson;
        return $this;
    }

    /**
     * @return JuridicalPersonEntity|null
     */
    public function getJuridicalPerson(): ?JuridicalPersonEntity
    {
        return $this->juridicalPerson;
    }

    /**
     * @param JuridicalPersonEntity|null $juridicalPerson
     * @return self
     */
    public function setJuridicalPerson(?JuridicalPersonEntity $juridicalPerson): self
    {
        $this->juridicalPerson = $juridicalPerson;
        return $this;
    }

}
