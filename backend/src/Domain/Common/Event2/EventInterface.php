<?php

namespace Panthir\Domain\Common\Event2;

interface EventInterface
{
    public function uuid(): EventId;

    public function type(): string;

    public function createdAt(): \DateTimeImmutable;
}
