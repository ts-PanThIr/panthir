<?php

namespace Panthir\Domain\Customer\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\Table(name: 'customer_contact')]
final class CustomerContact
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue('NONE')]
    private string $id;

    public function __construct(
        protected UuidInterface $uuid,

        #[ORM\Column]
        private string $name,

        #[ORM\Column]
        private string $phone,

        #[ORM\Column]
        private string $email,

        #[ManyToOne(targetEntity: Customer::class, inversedBy: "contacts")]
        #[JoinColumn(name: "customer_id", referencedColumnName: "id")]
        private Customer $customer
    )
    {
        $this->id = $uuid->__toString();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;
        return $this;
    }
}
