<?php

namespace Panthir\Infrastructure\CommonBundle\Event;

use Panthir\Domain\Common\ValueObject\AggregateRootId;

class EventAwareId extends AggregateRootId
{
    /** @var string */
    protected $uuid;
}
