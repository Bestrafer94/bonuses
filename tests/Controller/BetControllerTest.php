<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;

class BetControllerTest extends BaseWebTestCase
{
    public function testBet()
    {
        $this->login();
        $client = $this->makeClient();
        $client->request('GET', '/bet');
        $this->assertStatusCode(Response::HTTP_OK, $client);
    }
}
