<?php

namespace Tests\Integration\Application\UseCase\User;

use Doctrine\ORM\EntityManagerInterface;
use Panthir\Application\Common\Handler\HandlerRunner;
use Panthir\Application\UseCase\User\POPO\Input\RegisterPOPO;
use Panthir\Application\UseCase\User\UserCreateHandler;
use Panthir\Domain\User\Model\User;
use Panthir\Infrastructure\CommonBundle\Exception\HandlerException;
use Tests\Integration\CustomKernelTestCase;

class UserCreateHandlerTest extends CustomKernelTestCase
{
    public function testEmptyUserException()
    {
        $this->expectException(HandlerException::class);
        $this->expectExceptionMessage('The given e-mail is not valid.');
        $this->expectExceptionCode(400);

        self::bootKernel();
        $container = static::getContainer();

        /** @var UserCreateHandler $userHandler */
        $userHandler = $container->get(UserCreateHandler::class);
        $runner = $container->get(HandlerRunner::class);
        $runner->__invoke($userHandler, (new RegisterPOPO('')));
    }

    public function testBadEmailUserException()
    {
        $this->expectException(HandlerException::class);
        $this->expectExceptionMessage('The given e-mail is not valid.');
        $this->expectExceptionCode(400);
        self::bootKernel();
        $container = static::getContainer();


        /** @var UserCreateHandler $userHandler */
        $userHandler = $container->get(UserCreateHandler::class);
        HandlerRunner::run($userHandler, (new RegisterPOPO('asd')));
    }

    public function testEmptyPasswordUserCreation()
    {
        self::bootKernel();
        $container = static::getContainer();
        $email = $this->faker->email();

        $em = $container->get(EntityManagerInterface::class);
        /** @var UserCreateHandler $userHandler */
        $userHandler = $container->get(UserCreateHandler::class);
        $return = HandlerRunner::run($userHandler, (new RegisterPOPO($email)));

        /** @var User $bd_user */
        $bd_user = $em->getRepository(User::class)->findOneBy(['email' => $email]);
        $this->assertNotEmpty($bd_user->getEmail());
        $this->assertNotEmpty($bd_user->getPassword());
        $this->assertNotEmpty($bd_user->getPasswordResetToken());
        $this->assertEquals($return->getEmail(), $bd_user->getEmail());
    }

    public function testNotEmptyPassword()
    {
        self::bootKernel();
        $container = static::getContainer();
        $email = $this->faker->email();

        $em = $container->get(EntityManagerInterface::class);

        /** @var UserCreateHandler $userHandler */
        $userHandler = $container->get(UserCreateHandler::class);
        HandlerRunner::run($userHandler, (new RegisterPOPO(email: $email, password: 'teste')));

        /** @var User $bd_user */
        $bd_user = $em->getRepository(User::class)->findOneBy(['email' => $email]);
        $this->assertEmpty($bd_user->getPasswordResetToken());
    }

    public function testNotUniqueEmail()
    {
        $this->expectException(HandlerException::class);
        $this->expectExceptionMessage("There's already one user registered with this e-mail.");
        $this->expectExceptionCode(400);

        self::bootKernel();
        $container = static::getContainer();
        $email = $this->faker->email();

        /** @var UserCreateHandler $userHandler */
        $userHandler = $container->get(UserCreateHandler::class);
        HandlerRunner::run($userHandler, (new RegisterPOPO(email: $email)));

        HandlerRunner::run($userHandler, (new RegisterPOPO(email: $email)));
    }
}
