<?php

namespace Panthir\UI\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Panthir\Application\Common\Handler\HandlerRunner;
use Panthir\Application\UseCase\Customer\CustomerCreateHandler;
use Panthir\Application\UseCase\Customer\Normalizer\DTO\CustomerAddressDTO;
use Panthir\Application\UseCase\Customer\Normalizer\DTO\CustomerContactDTO;
use Panthir\Application\UseCase\Customer\Normalizer\DTO\CustomerCreateDTO;
use Panthir\Infrastructure\Faker\PortugalFactory;

class CustomerFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private readonly HandlerRunner         $handlerRunner,
        private readonly CustomerCreateHandler $customerCreateHandler
    )
    {
    }

    public static function getGroups(): array
    {
        return ['customer'];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $rand = rand(0, 9);

            $addresses = new ArrayCollection([]);
            while ($rand >= 0) {
                $fakerAddress = PortugalFactory::build();
                $addresses->add(
                    new CustomerAddressDTO(
                        name: $fakerAddress->domainName(),
                        country: $fakerAddress->country(),
                        district: (method_exists($fakerAddress, 'state')) ? $fakerAddress->state() : $fakerAddress->city(),
                        city: $fakerAddress->city(),
                        address: $fakerAddress->streetAddress(),
                        number: $fakerAddress->randomNumber(4),
                        zip: $fakerAddress->postcode(),
                        addressComplement: $fakerAddress->domainName()
                    )
                );
                $rand--;
            }

            $rand = rand(0, 9);
            $contacts = new ArrayCollection([]);
            while ($rand >= 0) {
                $fakerContact = PortugalFactory::build();
                $contacts->add(
                    new CustomerContactDTO(
                        name: $fakerContact->domainName(),
                        email: $fakerContact->email(),
                        phone: $fakerContact->phoneNumber()
                    )
                );
                $rand--;
            }

            $faker = PortugalFactory::build();
            $this->handlerRunner->__invoke($this->customerCreateHandler, (new CustomerCreateDTO(
                name: $faker->firstName(),
                surname: $faker->lastName(),
                document: $faker->taxpayerIdentificationNumber(),
                addresses: $addresses,
                contacts: $contacts,
            )));
        }

        $manager->flush();
    }
}
