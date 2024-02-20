<?php

namespace Panthir\Application\UseCase\Product;

use Panthir\Application\Common\DTO\DTOInterface;
use Panthir\Application\Common\Handler\AbstractHandler;
use Panthir\Application\UseCase\Product\Normalizer\DTO\ProductCreateDTO;
use Panthir\Domain\Product\Model\Category;
use Panthir\Domain\Product\Model\Product;
use Ramsey\Uuid\Uuid;

class ProductCreateHandler extends AbstractHandler
{
    public function supports(DTOInterface $object): bool
    {
        return $object instanceof ProductCreateDTO;
    }

    /**
     * @param DTOInterface|ProductCreateDTO $model
     * @return mixed
     */
    public function execute(DTOInterface|ProductCreateDTO $model): mixed
    {
        $category = $this->entityManager->getRepository(Category::class)->find($model->categoryId);

        $product = (new Product(Uuid::uuid4()))
            ->setName($model->name)
            ->setBrand($model->brand)
            ->setValue($model->value)
            ->setCategory($category)
            ;

        $this->entityManager->persist($product);
        return $product;
    }
}