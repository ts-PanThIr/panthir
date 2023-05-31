<?php

namespace App\Shared\DataFixtures;

use App\Domain\User\Manager\UserFactory;
use App\Domain\User\UserRoles;
use App\Shared\DTO\UserPOPO;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UsersFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(private UserFactory $userManager)
    {
    }

    public static function getGroups(): array
    {
        return ['user'];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $faker = Factory::create();
            $roles = constant(UserRoles::class. '::'. UserRoles::LIST_PROFILES[$faker->numberBetween(0, count(UserRoles::LIST_PROFILES) - 1)]);
            $userDTO = new UserPOPO($faker->email());
            $userDTO->setRoles($roles);

            $this->userManager->createUser($userDTO);
        }

        $manager->flush();
    }
}
