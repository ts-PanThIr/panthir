<?php

namespace Panthir\Infrastructure\Factory;

interface AfterCreatedFactoryInterface
{
    function afterCreated(): object;
}