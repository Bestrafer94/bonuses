<?php

declare(strict_types=1);

namespace App\Tests\Handler;

use App\Handler\Command\DepositCommand;
use App\Handler\DepositCommandHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class DepositCommandHandlerTest extends TestCase
{
    /**
     * @var DepositCommandHandler
     */
    private $depositCommandHandler;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|EventDispatcherInterface
     */
    private $eventDispatcherMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|DepositCommand
     */
    private $depositCommandMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|UserInterface
     */
    private $userMock;

    /**
     * @var int
     */
    private $depositValue = 500;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->depositCommandMock = $this->createMock(DepositCommand::class);
        $this->userMock = $this->createMock(UserInterface::class);
        $this->depositCommandMock->method('getUser')->willReturn($this->userMock);
        $this->depositCommandMock->method('getDepositValue')->willReturn($this->depositValue);
        $this->eventDispatcherMock = $this->createMock(EventDispatcherInterface::class);

        $this->depositCommandHandler = new DepositCommandHandler($this->eventDispatcherMock);
    }

    public function testHandle()
    {
        $this->eventDispatcherMock->expects($this->exactly(2))->method('dispatch');

        $this->depositCommandHandler->handle($this->depositCommandMock);
    }
}
