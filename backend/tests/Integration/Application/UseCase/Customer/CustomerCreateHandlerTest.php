<?php

namespace Tests\Integration\Application\UseCase\Customer;

use Doctrine\Common\Collections\ArrayCollection;
use Panthir\Application\Common\Handler\HandlerRunner;
use Panthir\Application\UseCase\Customer\CustomerCreateHandler;
use Panthir\Application\UseCase\Customer\Normalizer\DTO\CustomerAddressDTO;
use Panthir\Application\UseCase\Customer\Normalizer\DTO\CustomerContactDTO;
use Panthir\Application\UseCase\Customer\Normalizer\DTO\CustomerCreateDTO;
use Panthir\Domain\Customer\Model\Customer;
use Panthir\Infrastructure\CommonBundle\Exception\InvalidFieldException;
use Tests\Integration\CustomKernelTestCase;

class CustomerCreateHandlerTest extends CustomKernelTestCase
{
    public function testCustomerAsserts()
    {
        $this->expectException(InvalidFieldException::class);
        $this->expectExceptionCode(400);

        self::bootKernel();
        $container = static::getContainer();

        /** @var CustomerCreateHandler $userHandler */
        $userHandler = $container->get(CustomerCreateHandler::class);
        $runner = $container->get(HandlerRunner::class);
        $runner->__invoke($userHandler, (new CustomerCreateDTO('','', '')));
    }

    public function testPersonCreateSuccess()
    {
        self::bootKernel();
        $container = static::getContainer();

        /** @var CustomerCreateHandler $userHandler */
        $userHandler = $container->get(CustomerCreateHandler::class);
        $runner = $container->get(HandlerRunner::class);
        $return = $runner->__invoke($userHandler, (new CustomerCreateDTO(
            name: $this->faker->firstName(),
            surname: $this->faker->lastName(),
            document: $this->faker->taxpayerIdentificationNumber()
        )));

        $this->assertIsArray($return);
        $this->assertNotEmpty($return['id']);
    }

    public function testPersonCreateContactAndAddressSuccess()
    {
        self::bootKernel();
        $container = static::getContainer();

        /** @var CustomerCreateHandler $userHandler */
        $userHandler = $container->get(CustomerCreateHandler::class);
        $runner = $container->get(HandlerRunner::class);
        $return = $runner->__invoke($userHandler, (new CustomerCreateDTO(
            name: $this->faker->firstName(),
            surname: $this->faker->lastName(),
            document: $this->faker->taxpayerIdentificationNumber(),
            addresses: new ArrayCollection([
                (new CustomerAddressDTO(
                    name: $this->faker->domainName(),
                    country: $this->faker->country(),
                    district: $this->faker->state(),
                    city: $this->faker->city(),
                    address: $this->faker->streetAddress(),
                    number: $this->faker->randomNumber(4),
                    zip: $this->faker->postcode(),
                    addressComplement: $this->faker->domainName()
                ))
            ]),
            contacts: new ArrayCollection([
                (new CustomerContactDTO(
                    name: $this->faker->domainName(),
                    email: $this->faker->email(),
                    phone: $this->faker->phoneNumber()
                ))
            ]),
        )));

        $this->assertEmpty(array_diff(array_keys($return), ['surname', 'name', 'id', 'document']));
    }
}



