<?php

namespace Panthir\Application\UseCase\Customer;

use Panthir\Application\Common\Handler\AbstractHandler;
use Panthir\Application\UseCase\Customer\Normalizer\DTO\CustomerSearchDTO;
use \Panthir\Application\Common\DTO\DTOInterface;
use Panthir\Domain\Customer\Model\Customer;

class CustomerSearchHandler extends AbstractHandler
{
    /**
     * @param CustomerSearchDTO $model
     * @return mixed
     */
    public function execute(DTOInterface $model): mixed
    {
        if($model->getId()) {
            return $this->entityManager->getRepository(Customer::class)->find($model->getId());
        }
        return $this->entityManager->getRepository(Customer::class)->search($model);
    }
}
