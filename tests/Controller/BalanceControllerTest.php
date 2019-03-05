<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;

class BalanceControllerTest extends BaseWebTestCase
{
    public function testBalance()
    {
        $this->login();
        $client = $this->makeClient();
        $client->request('GET', '/balance');
        $this->assertStatusCode(Response::HTTP_OK, $client);
    }
}
