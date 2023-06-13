<?php

namespace Tests\Application\User;

use Tests\Application\CustomApplicationTestCase;

class PostTest extends CustomApplicationTestCase
{
    public function testSomething(): void
    {
        // test e.g. the profile page
        self::$authClient->request('POST', '/api/user/', [
            'email' => 'teste1@teste.com'
        ]);

        $content = self::$authClient->getResponse();

        $this->assertResponseStatusCodeSame(200);

    }
}
