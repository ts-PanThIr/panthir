<?php

namespace App\Shared\Transformer;

interface DTOTransformerInterface
{
    public static function transformFromObject(object $object);
    public static function transformFromObjects(iterable $objects): iterable;
}