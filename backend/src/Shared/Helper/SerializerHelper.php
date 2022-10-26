<?php

namespace App\Shared\Helper;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializerHelper
{
    public function __construct(private readonly ?string $modelName = null)
    {
    }

    public function collectionCallback($innerObject)
    {
        $serializer = new Serializer(normalizers: [new ObjectNormalizer()]);
        $collection = new ArrayCollection();

        foreach ($innerObject as $row) {
            $collection->add($serializer->denormalize($row, $this->modelName));
        }
        return $collection;
    }

    public function dateCallback($value)
    {
        if (!empty($value)) {
            return date_create_from_format("d/m/Y", $value);
        }
        return null;
    }
}
