<?php

namespace Panthir\Infrastructure\POPO;

use Doctrine\Common\Collections\ArrayCollection;

abstract class AbstractPOPOTransformer implements POPOInterface
{
    public static function transformFromObjects(iterable $objects): array
    {
        $dto = [];
        foreach ($objects as $object) {
            $dto[] = static::transformFromObject($object);
        }
        return $dto;
    }

    public static function transformFromObjectsToCollection(iterable $objects): ArrayCollection
    {
        $temp = new ArrayCollection();
        foreach ($objects as $object) {
            $temp->add(static::transformFromObject($object));
        }
        return $temp;
    }
}