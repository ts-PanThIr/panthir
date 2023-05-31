<?php

namespace Panthir\Infrastructure\POPO;

interface POPOInterface
{
    public static function transformFromObjects(iterable $objects): iterable;
}