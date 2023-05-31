<?php

namespace Panthir\Domain\User\ValueObject;

use Panthir\Domain\Common\ValueObject\AggregateRootId;

class UserId extends AggregateRootId
{
    /** @var  string */
    protected $uuid;
}