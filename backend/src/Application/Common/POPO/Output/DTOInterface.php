<?php

namespace Panthir\Application\Common\POPO\Output;

use Panthir\Application\Common\Transformer\TransformerInterface;

interface DTOInterface extends TransformerInterface
{
    public static function suports(): array;
}