<?php

namespace Panthir\Application\UseCase\Supplier\Normalizer;

use Panthir\Application\UseCase\Supplier\SupplierSearchHandler;
use Panthir\Domain\Supplier\Model\SupplierAddress;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SupplierAddressNormalizer  implements NormalizerInterface
{

    /**
     * @param SupplierAddress $object
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        return [
            'id' => $object->id,
            'name' => $object->name,
            'city' => $object->city,
            'addressComplement' => $object->addressComplement,
            'address' => $object->address,
            'country' => $object->country,
            'district' => $object->district,
            'number' => $object->number,
            'zip' => $object->zip,
            'type' => $object->getType()
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof SupplierAddress && SupplierSearchHandler::class === $format;
    }
}
