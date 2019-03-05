<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;

class UserProfileControllerTest extends BaseWebTestCase
{
    public function testUserProfile()
    {
        $this->login();
        $client = $this->makeClient();
        $client->request('GET', '/user-profile');
        $this->assertStatusCode(Response::HTTP_OK, $client);
    }
}
