<?php

namespace Panthir\Application\UseCase\Customer\Normalizer;

use Panthir\Application\UseCase\Customer\CustomerCreateHandler;
use Panthir\Domain\Customer\Model\Customer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CustomerCreateNormalizer implements NormalizerInterface
{
    /**
     * @param Customer $object
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        return [
            'name' => $object->getName(),
            'surname' => $object->getSurname(),
            'id' => $object->getId(),
            'document' => $object->getDocument()
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Customer && CustomerCreateHandler::class === $format;
    }
}
