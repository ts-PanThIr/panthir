<?php

namespace Panthir\Domain\Customer\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Panthir\Domain\Common\Model\AbstractAddress;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\Table(name: 'customer_address')]
final class CustomerAddress extends AbstractAddress
{
    public function __construct(
        protected UuidInterface $uuid,

        #[ManyToOne(targetEntity: Customer::class, inversedBy: "addresses")]
        #[JoinColumn(name: "person_id", referencedColumnName: "id")]
        private Customer $customer,
    )
    {
        $this->id = $uuid->__toString();
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
