<?php

namespace Panthir\Application\Common\Handler;

interface AfterExecutedHandlerInterface
{
    function afterExecuted($model): void;
}
