<?php

namespace Panthir\Infrastructure\Factory;

interface BeforeCreatedFactoryInterface
{
    function beforeCreated(): object;
}
