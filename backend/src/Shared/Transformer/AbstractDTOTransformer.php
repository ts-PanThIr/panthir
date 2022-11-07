<?php

namespace App\Shared\Transformer;

abstract class AbstractDTOTransformer implements DTOTransformerInterface
{
    public static function transformFromObjects(iterable $objects): array
    {
        $dto = [];
        foreach ($objects as $object) {
            $dto[] = static::transformFromObject($object);
        }
        return $dto;
    }
}