<?php

namespace Panthir\Application\Common\Handler;

use Panthir\Application\Common\DTO\DTOInterface;

interface CommonHandlerInterface
{
    function execute(DTOInterface $object): mixed;

    function supports(DTOInterface $object): bool;
}
