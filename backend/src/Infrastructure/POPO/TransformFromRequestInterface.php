<?php

namespace Panthir\Infrastructure\POPO;

use Symfony\Component\HttpFoundation\Request;

interface TransformFromRequestInterface
{
    public static function transformFromRequest(Request $request): object;
}