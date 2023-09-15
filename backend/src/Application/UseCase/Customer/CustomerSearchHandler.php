<?php

namespace Panthir\Application\UseCase\Customer;

use Panthir\Application\Common\Handler\AbstractHandler;
use Panthir\Application\UseCase\Customer\Normalizer\DTO\CustomerSearchDTO;
use \Panthir\Application\Common\DTO\DTOInterface;
use Panthir\Domain\Customer\Model\Customer;

class CustomerSearchHandler extends AbstractHandler
{

    public function supports(DTOInterface $object): bool
    {
        return $object instanceof CustomerSearchDTO;
    }

    /**
     * @param CustomerSearchDTO $model
     * @return mixed
     */
    public function execute(DTOInterface $model): mixed
    {
        if($model->id) {
            return $this->entityManager->getRepository(Customer::class)->find($model->id);
        }
        return $this->entityManager->getRepository(Customer::class)->search($model);
    }
}
