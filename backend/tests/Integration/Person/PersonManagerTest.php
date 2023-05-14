<?php

namespace App\Tests\Integration\Person;

use App\Person\Entity\PersonEntity;
use App\Person\Manager\PersonManager;
use App\Shared\DTO\PersonAddressDTO;
use App\Shared\DTO\PersonContactDTO;
use App\Shared\DTO\PersonDTO;
use App\Shared\Exception\InvalidFieldException;
use App\Shared\Exception\ManagerException;
use App\Tests\Integration\CustomKernelTestCase;
use Doctrine\Common\Collections\ArrayCollection;

class PersonManagerTest extends CustomKernelTestCase
{
    public function testEmptyPersonException()
    {
        $this->expectException(InvalidFieldException::class);
        self::bootKernel();
        $container = static::getContainer();

        /** @var PersonManager $personManager */
        $personManager = $container->get(PersonManager::class);
        $personManager->savePerson((new PersonDTO()));
    }

    public function testInvalidIdPersonException()
    {
        $this->expectException(ManagerException::class);
        self::bootKernel();
        $container = static::getContainer();

        /** @var PersonManager $personManager */
        $personManager = $container->get(PersonManager::class);
        $personManager->savePerson(
            (new PersonDTO())
                ->setId(9999999)
                ->setName($this->faker->firstName())
                ->setSurname($this->faker->lastName())
                ->setDocument($this->faker->taxpayerIdentificationNumber())
        );
    }

    public function testPersonCreateSuccess()
    {
        self::bootKernel();
        $container = static::getContainer();

        /** @var PersonManager $personManager */
        $personManager = $container->get(PersonManager::class);
        $personEntity = $personManager->savePerson(
            (new PersonDTO())
            ->setName($this->faker->firstName())
            ->setSurname($this->faker->lastName())
            ->setDocument($this->faker->taxpayerIdentificationNumber())
        );

        $this->assertInstanceOf(PersonEntity::class, $personEntity);
        $this->assertNotEmpty($personEntity->getId());
    }

    public function testPersonCreateAddressFailure()
    {
        self::bootKernel();
        $container = static::getContainer();

        try {
            /** @var PersonManager $personManager */
            $personManager = $container->get(PersonManager::class);
            $personManager->savePerson(
                (new PersonDTO())
                    ->setName($this->faker->firstName())
                    ->setSurname($this->faker->lastName())
                    ->setDocument($this->faker->taxpayerIdentificationNumber())
                    ->setAddresses(new ArrayCollection([new PersonAddressDTO()]))
            );
        } catch (\Exception $e) {
            $this->assertFalse(str_contains($e->getMessage(),PersonDTO::class));
            $this->assertInstanceOf(InvalidFieldException::class, $e);
        }
    }

    public function testPersonCreateContactFailure()
    {
        self::bootKernel();
        $container = static::getContainer();

        try {
            /** @var PersonManager $personManager */
            $personManager = $container->get(PersonManager::class);
            $personManager->savePerson(
                (new PersonDTO())
                    ->setName($this->faker->firstName())
                    ->setSurname($this->faker->lastName())
                    ->setDocument($this->faker->taxpayerIdentificationNumber())
                    ->setContacts(new ArrayCollection([new PersonContactDTO()]))
            );
        } catch (\Exception $e) {
            $this->assertFalse(str_contains($e->getMessage(), PersonDTO::class));
            $this->assertInstanceOf(InvalidFieldException::class, $e);
        }
    }

    public function testPersonCreateContactAndAddressSuccess()
    {
        self::bootKernel();
        $container = static::getContainer();

        /** @var PersonManager $personManager */
        $personManager = $container->get(PersonManager::class);
        $personEntity = $personManager->savePerson(
            (new PersonDTO())
                ->setName($this->faker->firstName())
                ->setSurname($this->faker->lastName())
                ->setDocument($this->faker->taxpayerIdentificationNumber())
                ->setContacts( new ArrayCollection([
                    (new PersonContactDTO())
                        ->setName($this->faker->domainName())
                        ->setPhone($this->faker->phoneNumber())
                        ->setEmail($this->faker->email())
                ]))
                ->setAddresses( new ArrayCollection([
                    (new PersonAddressDTO())
                        ->setName($this->faker->domainName())
                        ->setZip($this->faker->randomNumber(4) . '-' . $this->faker->randomNumber(3))
                        ->setNumber($this->faker->randomNumber(4))
                        ->setDistrict($this->faker->state())
                        ->setZip($this->faker->postcode())
                        ->setCountry($this->faker->country())
                        ->setCity($this->faker->city())
                        ->setAddress($this->faker->streetAddress())
                ]))
        );

        $this->assertNotEmpty($personEntity->getId());
        $this->assertIsArray($personEntity->getAddresses()->getValues());
        $this->assertIsArray($personEntity->getContacts()->getValues());
    }

}



