<?php

namespace Panthir\Application\Common\Transformer;

interface TransformerInterface
{
    public static function transformFromObject(iterable $objects): iterable;
}