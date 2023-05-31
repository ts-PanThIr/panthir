<?php

namespace Tests\Integration\Person;

use App\Domain\Person\Entity\PersonEntity;
use App\Domain\Person\Manager\PersonFactory;
use App\Shared\DTO\PersonAddressPOPO;
use App\Shared\DTO\PersonContactPOPO;
use App\Shared\DTO\PersonPOPO;
use App\Shared\Exception\InvalidFieldException;
use App\Shared\Exception\ManagerException;
use Doctrine\Common\Collections\ArrayCollection;
use Tests\Integration\CustomKernelTestCase;

class PersonManagerTest extends CustomKernelTestCase
{
    public function testEmptyPersonException()
    {
        $this->expectException(InvalidFieldException::class);
        self::bootKernel();
        $container = static::getContainer();

        /** @var PersonFactory $personManager */
        $personManager = $container->get(PersonFactory::class);
        $personManager->savePerson((new PersonPOPO()));
    }

    public function testInvalidIdPersonException()
    {
        $this->expectException(ManagerException::class);
        self::bootKernel();
        $container = static::getContainer();

        /** @var PersonFactory $personManager */
        $personManager = $container->get(PersonFactory::class);
        $personManager->savePerson(
            (new PersonPOPO())
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

        /** @var \App\Domain\Person\Manager\PersonFactory $personManager */
        $personManager = $container->get(PersonFactory::class);
        $personEntity = $personManager->savePerson(
            (new PersonPOPO())
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
            /** @var \App\Domain\Person\Manager\PersonFactory $personManager */
            $personManager = $container->get(PersonFactory::class);
            $personManager->savePerson(
                (new PersonPOPO())
                    ->setName($this->faker->firstName())
                    ->setSurname($this->faker->lastName())
                    ->setDocument($this->faker->taxpayerIdentificationNumber())
                    ->setAddresses(new ArrayCollection([new PersonAddressPOPO()]))
            );
        } catch (\Exception $e) {
            $this->assertFalse(str_contains($e->getMessage(),PersonPOPO::class));
            $this->assertInstanceOf(InvalidFieldException::class, $e);
        }
    }

    public function testPersonCreateContactFailure()
    {
        self::bootKernel();
        $container = static::getContainer();

        try {
            /** @var PersonFactory $personManager */
            $personManager = $container->get(PersonFactory::class);
            $personManager->savePerson(
                (new PersonPOPO())
                    ->setName($this->faker->firstName())
                    ->setSurname($this->faker->lastName())
                    ->setDocument($this->faker->taxpayerIdentificationNumber())
                    ->setContacts(new ArrayCollection([new PersonContactPOPO()]))
            );
        } catch (\Exception $e) {
            $this->assertFalse(str_contains($e->getMessage(), PersonPOPO::class));
            $this->assertInstanceOf(InvalidFieldException::class, $e);
        }
    }

    public function testPersonCreateContactAndAddressSuccess()
    {
        self::bootKernel();
        $container = static::getContainer();

        /** @var PersonFactory $personManager */
        $personManager = $container->get(PersonFactory::class);
        $personEntity = $personManager->savePerson(
            (new PersonPOPO())
                ->setName($this->faker->firstName())
                ->setSurname($this->faker->lastName())
                ->setDocument($this->faker->taxpayerIdentificationNumber())
                ->setContacts( new ArrayCollection([
                    (new PersonContactPOPO())
                        ->setName($this->faker->domainName())
                        ->setPhone($this->faker->phoneNumber())
                        ->setEmail($this->faker->email())
                ]))
                ->setAddresses( new ArrayCollection([
                    (new PersonAddressPOPO())
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



