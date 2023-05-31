<?php

namespace Tests\Integration\User;

use App\Domain\User\Entity\UserEntity;
use App\Domain\User\Manager\UserFactory;
use App\Shared\DTO\UserPOPO;
use App\Shared\Exception\ManagerException;
use Doctrine\ORM\EntityManagerInterface;
use Tests\Integration\CustomKernelTestCase;

class UserManagerTest extends CustomKernelTestCase
{
    public function testEmptyUserException()
    {
        $this->expectException(ManagerException::class);
        self::bootKernel();
        $container = static::getContainer();

        /** @var UserFactory $userManager */
        $userManager = $container->get(UserFactory::class);
        $userManager->createUser((new UserPOPO('')));
    }

    public function testBadEmailUserException()
    {
        $this->expectException(ManagerException::class);
        self::bootKernel();
        $container = static::getContainer();

        /** @var \App\Domain\User\Manager\UserFactory $userManager */
        $userManager = $container->get(UserFactory::class);
        $userManager->createUser((new UserPOPO('asd')));
    }

    public function testEmptyPasswordUserCreation()
    {
        self::bootKernel();
        $container = static::getContainer();
        $email = $this->faker->email();

        $em = $container->get(EntityManagerInterface::class);
        /** @var UserFactory $userManager */
        $userManager = $container->get(UserFactory::class);
        $user = $userManager->createUser((new UserPOPO($email)));
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
        $email = $this->faker->email();

        $em = $container->get(EntityManagerInterface::class);

        /** @var UserFactory $userManager */
        $userManager = $container->get(UserFactory::class);
        $userManager->createUser((new UserPOPO(email: $email, password: 'teste')));
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
        $email = $this->faker->email();

        $em = $container->get(EntityManagerInterface::class);

        /** @var \App\Domain\User\Manager\UserFactory $userManager */
        $userManager = $container->get(UserFactory::class);
        $userManager->createUser((new UserPOPO(email: $email)));
        $em->flush();

        $userManager->createUser((new UserPOPO(email: $email)));
    }
}
