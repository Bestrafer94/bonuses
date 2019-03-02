<?php

namespace tests\Factory;

use App\Entity\User;
use App\Factory\UserFactory;
use App\Factory\UserFactoryInterface;
use App\Model\UserModelInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFactoryTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|UserModelInterface
     */
    private $userModelMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|UserPasswordEncoderInterface
     */
    private $encoderMock;

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
        $this->encoderMock = $this->createMock(UserPasswordEncoderInterface::class);
        $this->userFactory = new UserFactory($this->encoderMock);
    }

    /**
     * @dataProvider userDataProvider
     *
     * @param string $userName
     * @param string $password
     * @param string $encodedPassword
     */
    public function testCreateUserProfile(string $userName, string $password, string $encodedPassword)
    {
        $this->encoderMock->method('encodePassword')->willReturn($encodedPassword);
        $this->userModelMock->method('getUsername')->willReturn($userName);
        $this->userModelMock->method('getPassword')->willReturn($password);

        $user = $this->userFactory->createUser($this->userModelMock);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($userName, $user->getUsername());
        $this->assertEquals($encodedPassword, $user->getPassword());
    }

    /**
     * @return array
     */
    public function userDataProvider(): array
    {
        return [
            ['email@email.com', 'password', 'encodedPassword1'],
            ['email2@email.com', 'password123', 'encodedPassword2'],
            ['ema5il@email.com', 'passwordabc', 'encodedPassword3'],
        ];
    }
}
