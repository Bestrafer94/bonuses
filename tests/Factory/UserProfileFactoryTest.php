<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\UserProfile;
use App\Factory\UserProfileFactory;
use App\Factory\UserProfileFactoryInterface;
use App\Model\UserProfileModerInterface;
use PHPUnit\Framework\TestCase;

class UserProfileFactoryTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|UserProfileModerInterface
     */
    private $userProfileModelMock;

    /**
     * @var UserProfileFactoryInterface
     */
    private $userProfileFactory;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->userProfileModelMock = $this->createMock(UserProfileModerInterface::class);
        $this->userProfileFactory = new UserProfileFactory();
    }

    /**
     * @dataProvider profileDataProvider
     *
     * @param string $name
     * @param string $lastName
     * @param int    $age
     * @param string $gender
     */
    public function testCreateUserProfile(string $name, string $lastName, int $age, string $gender)
    {
        $this->userProfileModelMock->method('getName')->willReturn($name);
        $this->userProfileModelMock->method('getLastName')->willReturn($lastName);
        $this->userProfileModelMock->method('getAge')->willReturn($age);
        $this->userProfileModelMock->method('getGender')->willReturn($gender);

        $userProfile = $this->userProfileFactory->createUserProfile($this->userProfileModelMock);

        $this->assertInstanceOf(UserProfile::class, $userProfile);
        $this->assertEquals($name, $userProfile->getName());
        $this->assertEquals($lastName, $userProfile->getLastName());
        $this->assertEquals($age, $userProfile->getAge());
        $this->assertEquals($gender, $userProfile->getGender());
    }

    /**
     * @return array
     */
    public function profileDataProvider(): array
    {
        return [
            ['name', 'lastName', 20, 'male'],
            ['otherName', 'lastName2', 15, 'female'],
            ['name', 'lastName', 35, 'male'],
        ];
    }
}
