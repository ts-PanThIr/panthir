<?php

namespace Tests\Application\User;

use Tests\Application\CustomApplicationAuthCase;

class GetTest extends CustomApplicationAuthCase
{
    public function testGetAllSuccess(): void
    {
        static::$client->request('GET', '/api/users/', [
//            'email' => 'teste1@teste.com'
        ]);

        $content = json_decode(static::$client->getResponse()->getContent(), true);
        $this->assertNotEmpty($content['data']);
        $this->assertEmpty(array_diff(array_keys($content['data'][0]), ['email', 'profile', 'id']));
        $this->assertResponseStatusCodeSame(200);
    }
}
