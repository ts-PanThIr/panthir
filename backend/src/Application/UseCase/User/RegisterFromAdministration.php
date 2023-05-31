<?php

namespace Panthir\Application\UseCase\User;

use Domain\User\Repository\UserRepositoryInterface;
use Panthir\Domain\User\Factory\UserFactoryInterface;
use Panthir\Domain\User\Model\User;
use Panthir\Infrastructure\Factory\User\UserCreateFactory;
use Panthir\Infrastructure\POPO\User\Register;

class RegisterFromAdministration
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private UserFactoryInterface $factory
    )
    {
    }

    public function handle(Register $request): User
    {
        $transaction = UserCreateFactory::create(
            $this->userRepository->findOneByUuid($request->userId()),
            $request->currency()
        );

        $this->repository->save($transaction);

        return $transaction->wallet();

        return $this->repository->getOneByUuid($request->uuid());
    }
}