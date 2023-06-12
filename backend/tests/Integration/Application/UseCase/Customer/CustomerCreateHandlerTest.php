<?php

namespace Tests\Integration\Application\UseCase\Customer;

use Doctrine\Common\Collections\ArrayCollection;
use Panthir\Application\Common\Handler\HandlerRunner;
use Panthir\Application\UseCase\Customer\CustomerCreateHandler;
use Panthir\Application\UseCase\Customer\POPO\Input\CustomerPOPO;
use Panthir\Domain\Customer\Model\Customer;
use Panthir\Infrastructure\CommonBundle\Exception\InvalidFieldException;
use Tests\Integration\CustomKernelTestCase;

class CustomerCreateHandlerTest extends CustomKernelTestCase
{
    public function testCustomerAsserts()
    {
        $this->expectException(InvalidFieldException::class);
        $this->expectExceptionMessage('The given e-mail is not valid.');
        $this->expectExceptionCode(400);

        self::bootKernel();
        $container = static::getContainer();

        /** @var CustomerCreateHandler $userHandler */
        $userHandler = $container->get(CustomerCreateHandler::class);
        $runner = $container->get(HandlerRunner::class);
        $runner::run($userHandler, (new CustomerPOPO('','', '')));
    }

    public function testPersonCreateSuccess()
    {
        $this->expectException(InvalidFieldException::class);
        $this->expectExceptionMessage('The given e-mail is not valid.');
        $this->expectExceptionCode(400);

        self::bootKernel();
        $container = static::getContainer();

        /** @var CustomerCreateHandler $userHandler */
        $userHandler = $container->get(CustomerCreateHandler::class);
        $runner = $container->get(HandlerRunner::class);
        $return = $runner::run($userHandler, (new CustomerPOPO(
            name: $this->faker->firstName(),
            surname: $this->faker->lastName(),
            document: $this->faker->taxpayerIdentificationNumber()
        )));

        $this->assertInstanceOf(Customer::class, $return);
        $this->assertNotEmpty($return->getId());
    }

    public function testPersonCreateAddressFailure()
    {
        self::bootKernel();
        $container = static::getContainer();

        try {
            /** @var \App\Domain\Person\Manager\PersonFactory $personManager */
            $personManager = $container->get(PersonFactory::class);
            $personManager->savePerson(
                (new CustomerCreatePOPO())
                    ->setName($this->faker->firstName())
                    ->setSurname($this->faker->lastName())
                    ->setDocument($this->faker->taxpayerIdentificationNumber())
                    ->setAddresses(new ArrayCollection([new CustomerAddressPOPO()]))
            );
        } catch (\Exception $e) {
            $this->assertFalse(str_contains($e->getMessage(),CustomerCreatePOPO::class));
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
                (new CustomerCreatePOPO())
                    ->setName($this->faker->firstName())
                    ->setSurname($this->faker->lastName())
                    ->setDocument($this->faker->taxpayerIdentificationNumber())
                    ->setContacts(new ArrayCollection([new CustomerContactPOPO()]))
            );
        } catch (\Exception $e) {
            $this->assertFalse(str_contains($e->getMessage(), CustomerCreatePOPO::class));
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
            (new CustomerCreatePOPO())
                ->setName($this->faker->firstName())
                ->setSurname($this->faker->lastName())
                ->setDocument($this->faker->taxpayerIdentificationNumber())
                ->setContacts( new ArrayCollection([
                    (new CustomerContactPOPO())
                        ->setName($this->faker->domainName())
                        ->setPhone($this->faker->phoneNumber())
                        ->setEmail($this->faker->email())
                ]))
                ->setAddresses( new ArrayCollection([
                    (new CustomerAddressPOPO())
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



