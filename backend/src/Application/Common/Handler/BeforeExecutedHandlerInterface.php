<?php

namespace Panthir\Application\Common\Handler;

use Panthir\Application\Common\POPO\POPOInterface;

interface BeforeExecutedHandlerInterface
{
    function beforeExecuted(POPOInterface $model): void;
}
