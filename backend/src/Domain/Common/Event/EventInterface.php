<?php

namespace Panthir\Domain\Common\Event;

interface EventInterface
{
    public function uuid(): EventId;

    public function type(): string;

    public function createdAt(): \DateTimeImmutable;
}
