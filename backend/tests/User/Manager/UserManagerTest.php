<?php

use App\Shared\Exception\ManagerException;
use App\Shared\DTO\UserDTO;
use App\User\Entity\UserEntity;
use App\User\Manager\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserManagerTest extends KernelTestCase
{
    public function testEmptyUserException()
    {
        $this->expectException(ManagerException::class);
        self::bootKernel();
        $container = static::getContainer();

        /** @var UserManager $userManager */
        $userManager = $container->get(UserManager::class);
        $userManager->createUser((new UserDTO('')));
    }

    public function testBadEmailUserException()
    {
        $this->expectException(ManagerException::class);
        self::bootKernel();
        $container = static::getContainer();

        /** @var UserManager $userManager */
        $userManager = $container->get(UserManager::class);
        $userManager->createUser((new UserDTO('asd')));
    }

    public function testEmptyPasswordUserCreation()
    {
        self::bootKernel();
        $container = static::getContainer();
        $email = Factory::create()->email();

        $em = $container->get(EntityManagerInterface::class);
        /** @var UserManager $userManager */
        $userManager = $container->get(UserManager::class);
        $user = $userManager->createUser((new UserDTO($email)));
        $em->flush();

        /** @var UserEntity $bd_user */
        $bd_user = $em->getRepository(UserEntity::class)->findOneBy(['email' => $email]);
        $this->assertNotEmpty($bd_user->getEmail());
        $this->assertNotEmpty($bd_user->getPassword());
        $this->assertNotEmpty($bd_user->getPasswordResetToken());
        $this->assertEquals($user->getEmail(), $bd_user->getEmail());
    }

    public function testNotEmptyPassword()
    {
        self::bootKernel();
        $container = static::getContainer();
        $email = Factory::create()->email();

        $em = $container->get(EntityManagerInterface::class);

        /** @var UserManager $userManager */
        $userManager = $container->get(UserManager::class);
        $userManager->createUser((new UserDTO(email: $email, password: 'teste')));
        $em->flush();

        /** @var UserEntity $bd_user */
        $bd_user = $em->getRepository(UserEntity::class)->findOneBy(['email' => $email]);
        $this->assertEmpty($bd_user->getPasswordResetToken());
    }

    public function testNotUniqueEmail()
    {
        $this->expectException(ManagerException::class);
        self::bootKernel();
        $container = static::getContainer();
        $email = Factory::create()->email();

        $em = $container->get(EntityManagerInterface::class);

        /** @var UserManager $userManager */
        $userManager = $container->get(UserManager::class);
        $userManager->createUser((new UserDTO(email: $email)));
        $em->flush();

        $userManager->createUser((new UserDTO(email: $email)));
    }
}
