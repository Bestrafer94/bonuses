<?php

declare(strict_types=1);

namespace App\Tests\Handler;

use App\Handler\Command\UserProfileCommand;
use App\Handler\UserProfileCommandHandler;
use App\Repository\UserProfileRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\UserInterface;

class UserProfileCommandHandlerTest extends TestCase
{
    /**
     * @var UserProfileCommandHandler
     */
    private $userProfileCommandHandler;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|UserProfileRepositoryInterface
     */
    private $userProfileRepository;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|UserProfileCommand
     */
    private $userProfileCommandMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|UserInterface
     */
    private $userMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->userProfileCommandMock = $this->createMock(UserProfileCommand::class);
        $this->userMock = $this->createMock(UserInterface::class);
        $this->userProfileCommandMock->method('getUser')->willReturn($this->userMock);
        $this->userProfileRepository = $this->createMock(UserProfileRepositoryInterface::class);

        $this->userProfileCommandHandler = new UserProfileCommandHandler($this->userProfileRepository);
    }

    public function testHandle()
    {
        $this->userProfileRepository->expects($this->once())->method('findOneByUser');

        $this->userProfileCommandHandler->handle($this->userProfileCommandMock);
    }
}
