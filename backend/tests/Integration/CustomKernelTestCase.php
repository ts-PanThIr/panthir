<?php

namespace Tests\Integration;

use Faker\Factory;
use Faker\Generator;
use Faker\Provider\pt_PT\Person;
use Faker\Provider\pt_PT\Payment;
use Faker\Provider\pt_PT\Address;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class CustomKernelTestCase extends KernelTestCase
{
    protected Generator $faker;

    protected function setUp(): void
    {
        // The Faker\Factory will create a ready to use Faker Generator
        $this->faker = Factory::create();
        $this->faker->addProvider(new Person($this->faker));
        $this->faker->addProvider(new Payment($this->faker));
        $this->faker->addProvider(new Address($this->faker));
    }
}