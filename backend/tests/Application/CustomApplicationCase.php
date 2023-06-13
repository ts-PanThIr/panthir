<?php

namespace Tests\Application;

use Panthir\Infrastructure\Repository\User\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

Abstract class CustomApplicationCase extends WebTestCase
{
    protected static ?KernelBrowser $client = null;

    protected function setUp(): void
    {
        if(null === self::$client){
            self::$client = static::createClient();
            self::$client->enableProfiler();
        }
    }
}
