<?php

namespace Panthir\Application\Common\Normalizer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CollectionNormalizer implements DenormalizerInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;

    public function __construct(
        private readonly array $objectToPopulate = []
    )
    {
    }

    public function denormalize($data, string $type, string $format = null, array $context = []): mixed
    {

        $teste = $context['parent_key'];

        $serializer = new Serializer(normalizers: [new ObjectNormalizer()]);
        $collection = new ArrayCollection();

        foreach ($data as $row) {
            $collection->add($serializer->denormalize($row, 'array'));
        }

        return $collection;
    }

    public function supportsDenormalization($data, string $type, string $format = null, array $context = []): bool
    {
        return true === is_array($data) && ($type === Collection::class);
    }
}
