<?php

namespace App\Shared\DataFixtures;

use App\Domain\Person\Manager\PersonFactory;
use App\Shared\DTO\PersonPOPO;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PersonFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(private PersonFactory $personManager)
    {
    }

    public static function getGroups(): array
    {
        return ['person'];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $faker = Factory::create();
            $personDTO = new PersonPOPO();
            $personDTO->setName($faker->name);
//            $personDTO->setDocument($faker->name);

            $this->personManager->savePerson($personDTO);
        }

        $manager->flush();
    }
}
