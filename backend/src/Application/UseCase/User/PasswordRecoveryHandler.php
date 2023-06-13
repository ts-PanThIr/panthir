<?php

namespace Panthir\Application\UseCase\User;


use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Panthir\Application\Common\DTO\DTOInterface;
use Panthir\Application\Common\Handler\AbstractHandler;
use Panthir\Application\Common\Handler\BeforeExecutedHandlerInterface;
use Panthir\Application\UseCase\User\Normalizer\DTO\PasswordRecoveryDTO;
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
     * @param PasswordRecoveryDTO $model
     * @return void
     * @throws HandlerException
     */
    public function beforeExecuted(DTOInterface $model): void
    {
        /** @var User $user */
        $user = $this->entityManager->getRepository(User::class)->findOneBy(["email" => $model->getEmail()]);
        if (empty($user)) {
            throw new HandlerException("Was't possible to send the E-mail to reset user password.", 400);
        }

        $this->user = $user;
    }

    /**
     * @param PasswordRecoveryDTO $userDTO
     * @return User
     * @throws JWTEncodeFailureException
     */
    public function execute(DTOInterface $userDTO): User
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
