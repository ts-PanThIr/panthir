<?php

namespace Panthir\Application\UseCase\User;

use Panthir\Application\Common\Handler\AbstractHandler;
use Panthir\Application\UseCase\User\Normalizer\DTO\UserSearchDTO;
use \Panthir\Application\Common\DTO\DTOInterface;
use Panthir\Domain\User\Model\User;

class UserSearchHandler extends AbstractHandler
{
    /**
     * @param UserSearchDTO $model
     * @return array
     */
    public function execute(DTOInterface $model): array
    {
        $users = $this->entityManager->getRepository(User::class)->search($model);
        return $users;
    }
}
