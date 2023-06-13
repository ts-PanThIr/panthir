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
     * @return mixed
     */
    public function execute(DTOInterface $model): mixed
    {
        if($model->getId()) {
            $user = $this->entityManager->getRepository(User::class)->find($model->getId());
            return $user;
        }
        $users = $this->entityManager->getRepository(User::class)->search($model);
        return $users;
    }
}
