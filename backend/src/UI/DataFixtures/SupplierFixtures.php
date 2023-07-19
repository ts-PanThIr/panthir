<?php

namespace Panthir\UI\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Panthir\Application\Common\Handler\HandlerRunner;
use Panthir\Application\UseCase\Supplier\SupplierCreateHandler;
use Panthir\Application\UseCase\Supplier\Normalizer\DTO\SupplierAddressDTO;
use Panthir\Application\UseCase\Supplier\Normalizer\DTO\SupplierContactDTO;
use Panthir\Application\UseCase\Supplier\Normalizer\DTO\SupplierCreateDTO;
use Panthir\Domain\Supplier\ValueObject\AddressType;
use Panthir\Domain\Supplier\ValueObject\ContactType;
use Panthir\Infrastructure\Faker\PortugalFactory;

class SupplierFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private readonly HandlerRunner         $handlerRunner,
        private readonly SupplierCreateHandler $supplierCreateHandler
    )
    {
    }

    public static function getGroups(): array
    {
        return ['supplier'];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $rand = count(AddressType::cases()) -1;

            $addresses = new ArrayCollection([]);
            while ($rand >= 0) {
                $fakerAddress = PortugalFactory::build();
                $addresses->add(
                    new SupplierAddressDTO(
                        name: $fakerAddress->domainName(),
                        country: $fakerAddress->country(),
                        district: (method_exists($fakerAddress, 'state')) ? $fakerAddress->state() : $fakerAddress->city(),
                        city: $fakerAddress->city(),
                        address: $fakerAddress->streetAddress(),
                        number: $fakerAddress->randomNumber(4),
                        zip: $fakerAddress->postcode(),
                        type: AddressType::cases()[$rand]->value,
                        addressComplement: $fakerAddress->domainName()
                    )
                );
                $rand--;
            }

            $rand = count(ContactType::cases()) -1;
            $contacts = new ArrayCollection([]);
            while ($rand >= 0) {
                $fakerContact = PortugalFactory::build();
                $contacts->add(
                    new SupplierContactDTO(
                        name: $fakerContact->domainName(),
                        email: $fakerContact->email(),
                        phone: $fakerContact->phoneNumber(),
                        type: ContactType::cases()[$rand]->value,
                    )
                );
                $rand--;
            }

            $faker = PortugalFactory::build();
            $this->handlerRunner->__invoke($this->supplierCreateHandler, (new SupplierCreateDTO(
                name: $faker->firstName(),
                nickname: $faker->lastName(),
                document: $faker->taxpayerIdentificationNumber(),
                addresses: $addresses,
                contacts: $contacts,
            )));
        }

        $manager->flush();
    }
}
