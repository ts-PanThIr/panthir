<?php

namespace Panthir\Application\UseCase\Product;

use Panthir\Application\Common\Handler\AbstractHandler;
use Panthir\Application\UseCase\Product\Normalizer\DTO\ProductSearchDTO;
use \Panthir\Application\Common\DTO\DTOInterface;
use Panthir\Domain\Product\Model\Category;

class CategorySearchHandler extends AbstractHandler
{

    public function supports(DTOInterface $object): bool
    {
        return $object instanceof ProductSearchDTO;
    }

    /**
     * @param ProductSearchDTO $model
     * @return mixed
     */
    public function execute(DTOInterface $model): mixed
    {
        return $this->entityManager->getRepository(Category::class)->getTree();
    }
}
