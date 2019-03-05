<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;

class DepositControllerTest extends BaseWebTestCase
{
    public function testDeposit()
    {
        $this->login();
        $client = $this->makeClient();
        $client->request('GET', '/deposit');
        $this->assertStatusCode(Response::HTTP_OK, $client);
    }
}
