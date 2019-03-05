<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends BaseWebTestCase
{
    public function testLogin()
    {
        $client = $this->makeClient();
        $client->request('GET', '/login');
        $this->assertStatusCode(Response::HTTP_OK, $client);
    }

    public function testLogout()
    {
        $client = $this->makeClient();
        $client->request('GET', '/logout');
        $this->assertStatusCode(Response::HTTP_FOUND, $client);
    }
}
