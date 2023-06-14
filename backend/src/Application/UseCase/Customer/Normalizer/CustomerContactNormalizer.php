<?php

namespace Panthir\Application\UseCase\Customer\Normalizer;

use Panthir\Application\UseCase\Customer\CustomerSearchHandler;
use Panthir\Domain\Customer\Model\CustomerContact;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CustomerContactNormalizer  implements NormalizerInterface
{

    /**
     * @param CustomerContact $object
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        return [
            'id' => $object->getId(),
            'name' => $object->getName(),
            'email' => $object->getEmail(),
            'phone' => $object->getPhone()
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof CustomerContact && CustomerSearchHandler::class === $format;
    }
}
