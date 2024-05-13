<?php

namespace Panthir\Application\Common\Handler;

interface BeforeExecutedHandlerInterface
{
    function beforeExecuted($model): void;
}
