<?php

namespace Panthir\Application\Common\Handler;

use Panthir\Application\Common\POPO\POPOInterface;

interface CommonHandlerInterface
{
    function execute(POPOInterface $object): object;
}