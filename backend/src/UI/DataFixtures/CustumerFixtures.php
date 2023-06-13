<?php

namespace Panthir\UI\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Panthir\Application\Common\Handler\HandlerRunner;
use Panthir\Application\UseCase\Customer\CustomerCreateHandler;
use Panthir\Application\UseCase\Customer\Normalizer\DTO\CustomerCreateDTO;

class CustumerFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private readonly HandlerRunner $handlerRunner,
        private CustomerCreateHandler  $customerCreateHandler
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
            $faker = Factory::create();
            $this->handlerRunner->__invoke($this->customerCreateHandler,
                new CustomerCreateDTO(
                    name: $faker->firstName,
                    surname: $faker->lastName,
                    document: $faker->lastName,
//                    mainAddress: $faker->name,
//                    mainContact: $faker->name,
                    addresses: $faker->name,
                    contacts: $faker->name,
                    birthDate: $faker->name,
                    secondaryDocument: $faker->name,
                    additionalInformation: $faker->name
                )
            );
        }

        $manager->flush();
    }
}
