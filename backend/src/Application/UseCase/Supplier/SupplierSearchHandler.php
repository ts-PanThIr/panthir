<?php

namespace Panthir\Application\UseCase\Supplier;

use Panthir\Application\Common\Handler\AbstractHandler;
use Panthir\Application\UseCase\Supplier\Normalizer\DTO\SupplierSearchDTO;
use \Panthir\Application\Common\DTO\DTOInterface;
use Panthir\Domain\Supplier\Model\Supplier;

class SupplierSearchHandler extends AbstractHandler
{
    /**
     * @param SupplierSearchDTO $model
     * @return mixed
     */
    public function execute(DTOInterface $model): mixed
    {
        if($model->id) {
            return $this->entityManager->getRepository(Supplier::class)->find($model->id);
        }
        return $this->entityManager->getRepository(Supplier::class)->search($model);
    }
}
