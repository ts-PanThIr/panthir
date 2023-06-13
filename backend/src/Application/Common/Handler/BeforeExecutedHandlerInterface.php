<?php

namespace Panthir\Application\Common\Handler;

use Panthir\Application\Common\DTO\DTOInterface;

interface BeforeExecutedHandlerInterface
{
    function beforeExecuted(DTOInterface $model): void;
}
