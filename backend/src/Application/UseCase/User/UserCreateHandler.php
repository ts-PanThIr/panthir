<?php

namespace Panthir\Application\UseCase\User;

use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Panthir\Application\Common\Handler\AbstractHandler;
use Panthir\Application\Common\Handler\AfterExecutedHandlerInterface;
use Panthir\Application\Common\Handler\BeforeExecutedHandlerInterface;
use Panthir\Application\Common\POPO\POPOInterface;
use Panthir\Application\UseCase\User\POPO\RegisterPOPO;
use Panthir\Domain\User\DomainServices\PasswordHashGenerator;
use Panthir\Domain\User\DomainServices\PasswordResetTokenGenerator;
use Panthir\Domain\User\Model\User;
use Panthir\Domain\User\ValueObject\UserId;
use Panthir\Domain\User\ValueObject\UserRoles;
use Panthir\Infrastructure\CommonBundle\Exception\HandlerException;
use Panthir\Infrastructure\Messenger\Model\EmailNotification;
use Symfony\Component\Messenger\MessageBusInterface;

class UserCreateHandler extends AbstractHandler implements BeforeExecutedHandlerInterface, AfterExecutedHandlerInterface
{
    private ?User $user;

    public function __construct(
        EntityManagerInterface                          $entityManager,
        protected           MessageBusInterface         $bus,
        private    readonly PasswordHashGenerator       $passwordHasher,
        protected           PasswordResetTokenGenerator $passwordResetTokenGenerator
    )
    {
        parent::__construct(entityManager: $entityManager);
    }

    /**
     * @param RegisterPOPO $model
     * @return void
     * @throws HandlerException
     */
    public function beforeExecuted(POPOInterface $model): void
    {
        if (!filter_var($model->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new HandlerException("The given e-mail is not valid.", 400);
        }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(["email" => $model->getEmail()]);
        if(!empty($user)) {
            throw new HandlerException("There's already one user registered with this e-mail.", 400);
        }
        $this->user = $user;
    }

    /**
     * @param RegisterPOPO $model
     * @return User
     * @throws JWTEncodeFailureException
     */
    public function execute(POPOInterface $model): User
    {
        $resetToken = null;
        if(empty($model->getPassword())){
            $resetToken = $this->passwordResetTokenGenerator->__invoke();
            $hashedPassword = $this->passwordHasher->__invoke(base64_encode(random_bytes(10)));
        } else{
            $hashedPassword = $this->passwordHasher->__invoke($model->getPassword());
        }

        $this->user = User::create(
            userId: new UserId(),
            email: $model->getEmail(),
            roles: empty($model->getRoles()) ? UserRoles::PROFILE_VIEWER : $model->getRoles(),
            passwordResetToken: $resetToken,
            password: $hashedPassword
        );

        $this->entityManager->persist($this->user);

        return $this->user;
    }

    /**
     * @param POPOInterface $model
     * @return void
     */
    public function afterExecuted(POPOInterface $model): void
    {
        if(empty($this->user->getPasswordResetToken())){
            return;
        }

        $this->bus->dispatch( new EmailNotification(
            userEmail: $this->user->getEmail(),
            resetPasswordtoken: $this->user->getPasswordResetToken()
        ));
    }
}