<?php

namespace tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = $this->makeClient();
        $client->request('GET', '/login');
        $this->assertStatusCode(200, $client);
    }
}
