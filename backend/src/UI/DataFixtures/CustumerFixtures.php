<?php

namespace Panthir\UI\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Panthir\Application\Common\Handler\HandlerRunner;
use Panthir\Application\UseCase\Customer\CustomerCreateHandler;
use Panthir\Application\UseCase\Customer\POPO\Input\CustomerPOPO;

class CustumerFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(private CustomerCreateHandler $customerCreateHandler)
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
            HandlerRunner::run($this->customerCreateHandler,
                new CustomerPOPO(
                    name: $faker->name,
                )
            );
        }

        $manager->flush();
    }
}
