<?php

namespace Tests\Application;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

Abstract class CustomApplicationTestCase extends WebTestCase
{
    private string $userUsername = 'john@doe.com';
    private string $userPassword = 'password';
    protected string $host = 'http://nginx-test/api/';
    protected array $headers = ['HTTP_CONTENT_TYPE' => 'application/json'];

    protected function setUp(): void
    {
        $client = static::createClient();
        $client->enableProfiler();
        $client->request('POST', $this->host.'login', [
            'headers' => $this->headers,
            'email' => $this->userUsername,
            'password' => $this->userPassword
        ]);

        $data =  json_decode($client->getResponse()->getContent(), true);
        $this->headers['HTTP_AUTHORIZATION'] = 'Bearer ' . $data['token'];
    }

    protected function requestAsPost(KernelBrowser &$client, string $path, array $data): void
    {
        $this->requestAsGivenMethod($client, $path, $data, 'POST');
    }

    protected function requestAsGet(KernelBrowser &$client, string $path, array $data): void
    {
        $this->requestAsGivenMethod($client, $path, $data, 'GET');
    }

    protected function requestAsGivenMethod(KernelBrowser &$client, string $path, array $data, string $method): void
    {
        $client->request($method,
            $this->host.$path,
            ["data" => json_encode($data)],
            [],
            $this->headers,
        );
    }
}