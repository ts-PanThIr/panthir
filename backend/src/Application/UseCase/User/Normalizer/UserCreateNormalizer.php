<?php

namespace Panthir\Application\UseCase\User\Normalizer;

use Panthir\Application\UseCase\User\UserCreateHandler;
use Panthir\Domain\User\Model\User;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserCreateNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        return 'abroba';
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof User && UserCreateHandler::class === $format;
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