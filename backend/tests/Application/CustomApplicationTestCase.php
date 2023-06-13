<?php

namespace Tests\Application;

use Panthir\Infrastructure\Repository\User\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

Abstract class CustomApplicationTestCase extends WebTestCase
{
    protected static ?KernelBrowser $client = null;
    protected static ?KernelBrowser $authClient = null;

    protected function setUp(): void
    {
        if(null === self::$client){
            self::$client = static::createClient();
            self::$client->enableProfiler();
        }

        if(null === self::$authClient){
            self::$authClient = clone self::$client;

            self::$authClient->setServerParameter('CONTENT_TYPE', 'application/json');
            self::$authClient->setServerParameter('HTTP_ACCEPT', 'application/json');
            $userRepository = static::getContainer()->get(UserRepository::class);
            $testUser = $userRepository->findOneByEmail('john@doe.com');
            self::$authClient->loginUser($testUser);
        }
    }
}