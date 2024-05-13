<?php

namespace Panthir\Application\Common\Handler;

interface CommonHandlerInterface
{
    function execute($model): mixed;

    function supports($model): bool;
}
