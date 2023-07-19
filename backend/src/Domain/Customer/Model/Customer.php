<?php

namespace Panthir\Domain\Customer\Model;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Panthir\Domain\Common\Model\AbstractPerson;
use Panthir\Domain\Common\Model\CountableTrait;
use Panthir\Infrastructure\Repository\Person\CustomerRepository;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ORM\Table(name: 'person')]
final class Customer extends AbstractPerson
{
    use CountableTrait;
    use BlameableEntity;
    use TimestampableEntity;

    public function __construct(
        protected UuidInterface $uuid,

        #[ORM\Column(name: 'surname')]
        private string $surname,

        #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
        private ?DateTimeInterface $birthDate = null,
    )
    {
        parent::__construct();
        $this->id = $uuid->__toString();
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): Customer
    {
        $this->surname = $surname;
        return $this;
    }

    public function getMainAddress(): ?CustomerAddress
    {
        return $this->mainAddress;
    }

    public function setBirthDate(?DateTimeInterface $birthDate): Customer
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function getBirthDate(): ?String
    {
        if(empty($this->birthDate)) {
            return null;
        }
        return date_format($this->birthDate, 'd/m/Y');
    }

    public function getRawBirthDate(): ?DateTimeInterface
    {
        return $this->birthDate;
    }
}
