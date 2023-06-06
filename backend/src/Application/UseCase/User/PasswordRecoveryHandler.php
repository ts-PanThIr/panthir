<?php

namespace Panthir\Application\UseCase\User;

use App\Shared\DTO\UserPOPO;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Panthir\Application\Common\Handler\AbstractHandler;
use Panthir\Application\Common\Handler\BeforeExecutedHandlerInterface;
use Panthir\Application\Common\POPO\POPOInterface;
use Panthir\Domain\User\DomainServices\PasswordResetTokenGenerator;
use Panthir\Domain\User\Model\User;
use Panthir\Infrastructure\CommonBundle\Exception\HandlerException;
use Panthir\Infrastructure\Messenger\Model\EmailNotification;
use Symfony\Component\Messenger\MessageBusInterface;

class PasswordRecoveryHandler extends AbstractHandler implements BeforeExecutedHandlerInterface
{
    private ?User $user;

    public function __construct(
        EntityManagerInterface $entityManager,
        protected MessageBusInterface $bus,
        protected PasswordResetTokenGenerator $passwordResetTokenGenerator
    )
    {
        parent::__construct(entityManager: $entityManager);
    }

    /**
     * @param UserPOPO $model
     * @return void
     * @throws HandlerException
     */
    public function beforeExecuted(POPOInterface $model): void
    {
        /** @var User $user */
        $user = $this->entityManager->getRepository(User::class)->findOneBy(["email" => $model->getEmail()]);
        if (empty($user)) {
            throw new HandlerException("Was't possible to send the E-mail to reset user password.", 400);
        }

        $this->user = $user;
    }

    /**
     * @param UserPOPO $userDTO
     * @return User
     * @throws JWTEncodeFailureException
     */
    public function execute(POPOInterface $userDTO): User
    {
        $this->user->setPasswordResetToken($this->passwordResetTokenGenerator->__invoke());

        $this->entityManager->persist($this->user);

        $this->bus->dispatch(new EmailNotification(
            userEmail: $this->user->getEmail(),
            resetPasswordtoken: $this->user->getPasswordResetToken()
        ));

        return $this->user;
    }
}