<?php

namespace tests\Factory;

use App\Entity\User;
use App\Factory\UserFactory;
use App\Factory\UserFactoryInterface;
use App\Model\UserModelInterface;
use PHPUnit\Framework\TestCase;

class UserFactoryTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|UserModelInterface
     */
    private $userModelMock;

    /**
     * @var UserFactoryInterface
     */
    private $userFactory;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->userModelMock = $this->createMock(UserModelInterface::class);
        $this->userFactory = new UserFactory();
    }

    /**
     * @dataProvider userDataProvider
     *
     * @param string $userName
     * @param string $password
     * @param string $email
     */
    public function testCreateUserProfile(string $userName, string $password)
    {
        $this->userModelMock->method('getUsername')->willReturn($userName);
        $this->userModelMock->method('getPassword')->willReturn($password);

        $user = $this->userFactory->createUser($this->userModelMock);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($userName, $user->getUsername());
        $this->assertEquals($password, $user->getPassword());
    }

    /**
     * @return array
     */
    public function userDataProvider(): array
    {
        return [
            ['email@email.com', 'password'],
            ['email2@email.com', 'password123'],
            ['ema5il@email.com', 'passwordabc'],
        ];
    }
}
