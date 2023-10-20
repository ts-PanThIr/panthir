<?php

namespace Panthir\Application\UseCase\Supplier\Normalizer;

use Panthir\Application\UseCase\Supplier\SupplierEditHandler;
use Panthir\Domain\Supplier\Model\Supplier;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SupplierCreateNormalizer implements NormalizerInterface
{
    /**
     * @param Supplier $object
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        return [
            'name' => $object->getName(),
            'nickName' => $object->getNickName(),
            'id' => $object->getId(),
            'document' => $object->getDocument()
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof Supplier && $format == SupplierEditHandler::class;
    }
}
