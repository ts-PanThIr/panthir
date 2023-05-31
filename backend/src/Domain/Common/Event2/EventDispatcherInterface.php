<?php

namespace Panthir\Domain\Common\Event2;

interface EventDispatcherInterface
{
    public function record(EventInterface $event): void;

    public function dispatch(): void;
}
