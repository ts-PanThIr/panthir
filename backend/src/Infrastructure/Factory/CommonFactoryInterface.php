<?php

namespace Panthir\Infrastructure\Factory;

use Panthir\Infrastructure\POPO\POPOInterface;

interface CommonFactoryInterface
{
    function execute(POPOInterface $object): object;
}