<?php

namespace Panthir\Application\Common\Handler;

use Panthir\Application\Common\POPO\POPOInterface;

interface AfterExecutedHandlerInterface
{
    function afterExecuted(POPOInterface $model): void;
}