<?php

use App\Person\Manager\PersonManager;
use App\Shared\DTO\PersonDTO;
use App\Shared\Exception\ManagerException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PersonManagerTest extends KernelTestCase
{
    public function testEmptyPersonException()
    {
        $this->expectException(ManagerException::class);
        self::bootKernel();
        $container = static::getContainer();

        /** @var PersonManager $personManager */
        $personManager = $container->get(PersonManager::class);
        $personManager->savePerson((new PersonDTO()));
    }
}
