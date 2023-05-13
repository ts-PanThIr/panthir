<?php

namespace App\Shared\DataFixtures;

use App\Person\Manager\PersonManager;
use App\Shared\DTO\PersonDTO;
use App\Shared\DTO\UserDTO;
use App\User\UserRoles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PersonFixtures extends Fixture
{
    public function __construct(private PersonManager $personManager)
    {
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $faker = Factory::create();
            $personDTO = new PersonDTO();
            $personDTO->setName($faker->name);
//            $personDTO->setDocument($faker->name);

            $this->personManager->createPerson($personDTO);
        }

        $manager->flush();
    }
}
