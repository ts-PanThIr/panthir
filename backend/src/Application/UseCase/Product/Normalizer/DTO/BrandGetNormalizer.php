<?php

namespace Panthir\Application\UseCase\Product\Normalizer\DTO;

use Panthir\Application\UseCase\Product\ProductGetBrandsHandler;
use Panthir\Application\UseCase\Product\ProductSearchHandler;
use Panthir\Domain\Product\Model\Category;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class BrandGetNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * @param Category $object
     * @param string|null $format
     * @param array $context
     * @return array
     * @throws ExceptionInterface
     */
    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        if (empty($object)) return [];

        $data = [];
        foreach ($object as $brand) {
            $data[] = [
                'name' => $brand->getName(),
                'id' => $brand->getId()
            ];
        }

        return $data;
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return ProductGetBrandsHandler::class === $format;
    }
}
