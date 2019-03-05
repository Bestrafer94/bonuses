<?php

namespace App\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

abstract class BaseWebTestCase extends WebTestCase
{
    protected function login()
    {
        $fixtures = $this->loadFixtures(
            [
                'App\DataFixtures\UserData',
                'App\DataFixtures\RealMoneyWalletData',
                'App\DataFixtures\UserProfileData',
            ]
        )->getReferenceRepository();
        $this->loginAs($fixtures->getReference('user-9'), 'main');
    }
}
