<?php

namespace Panthir\Application\UseCase\User;

use Domain\User\Repository\UserRepositoryInterface;

class RegisterHandler
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private UserFactoryInterface $factory
    )
    {
    }

    /**
     * @param GetUser $request
     * @return User
     * @throws UserNotFoundException
     */
    public function handle(GetUser $request): User
    {
        return $this->repository->getOneByUuid($request->uuid());
    }
}