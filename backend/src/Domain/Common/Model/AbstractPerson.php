<?php

namespace Panthir\Domain\Common\Model;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Panthir\Domain\Customer\Model\Customer;
use Panthir\Domain\Supplier\Model\Supplier;
use Ramsey\Uuid\UuidInterface;

#[Entity]
#[ORM\Table(name: 'person')]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "discriminator", type: "string")]
#[ORM\DiscriminatorMap([
    'person' => AbstractPerson::class,
    'customer' => Customer::class,
    'supplier' => Supplier::class
])]
abstract class AbstractPerson
{
    use CountableTrait;
    use BlameableEntity;
    use TimestampableEntity;

    private readonly UuidInterface $uuid;

    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue('NONE')]
    protected string $id;

    #[ORM\Column]
    protected string $document;

    #[ORM\Column(name: 'name')]
    protected string $name;

    #[ORM\Column(nullable: true)]
    protected ?string $secondaryDocument = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    protected ?string $additionalInformation = null;

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @param UuidInterface $uuid
     * @return $this
     */
    public function setUuid(UuidInterface $uuid): self
    {
        $this->uuid = $uuid;
        $this->id = $uuid->toString();

        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDocument(): string
    {
        return $this->document;
    }

    /**
     * @param string $document
     * @return $this
     */
    public function setDocument(string $document): self
    {
        $this->document = $document;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSecondaryDocument(): ?string
    {
        return $this->secondaryDocument;
    }

    /**
     * @param string|null $secondaryDocument
     * @return $this
     */
    public function setSecondaryDocument(?string $secondaryDocument): self
    {
        $this->secondaryDocument = $secondaryDocument;
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
     * @return $this
     */
    public function setAdditionalInformation(?string $additionalInformation): self
    {
        $this->additionalInformation = $additionalInformation;
        return $this;
    }
}
