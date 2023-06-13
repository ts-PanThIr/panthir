<?php

namespace Panthir\Application\UseCase\Customer\Normalizer;

use Panthir\Application\UseCase\Customer\CustomerCreateHandler;
use Panthir\Domain\User\Model\User;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CustomerCreateNormalizer implements NormalizerInterface, DenormalizerInterface
{
    /**
     * @param User $object
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        return [
            'email' => $object->getEmail(),
            'profile' => $object->getProfile(),
            'id' => $object->getId()
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof User && CustomerCreateHandler::class === $format;
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        return $data instanceof User;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        // TODO: Implement supportsDenormalization() method.
    }
}
