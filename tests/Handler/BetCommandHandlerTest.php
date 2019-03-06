<?php

declare(strict_types=1);

namespace App\Tests\Handler;

use App\Entity\User;
use App\Generator\BetScoreGeneratorInterface;
use App\Handler\BetCommandHandler;
use App\Handler\Command\BetCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class BetCommandHandlerTest extends TestCase
{
    /**
     * @var BetCommandHandler
     */
    private $betCommandHandler;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|EventDispatcherInterface
     */
    private $eventDispatcherMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|BetScoreGeneratorInterface
     */
    private $betScoreGeneratorMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|BetCommand
     */
    private $betCommandMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|User
     */
    private $userMock;

    /**
     * @var int
     */
    private $betValue = 500;

    /**
     * @var int
     */
    private $score = 450;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->betCommandMock = $this->createMock(BetCommand::class);
        $this->userMock = $this->createMock(User::class);
        $this->betCommandMock->method('getUser')->willReturn($this->userMock);
        $this->betCommandMock->method('getBetValue')->willReturn($this->betValue);
        $this->eventDispatcherMock = $this->createMock(EventDispatcherInterface::class);
        $this->betScoreGeneratorMock = $this->createMock(BetScoreGeneratorInterface::class);
        $this->betScoreGeneratorMock->method('generate')->willReturn($this->score);

        $this->betCommandHandler = new BetCommandHandler(
            $this->eventDispatcherMock,
            $this->betScoreGeneratorMock);
    }

    public function testHandle()
    {
        $this->eventDispatcherMock->expects($this->exactly(3))->method('dispatch');
        $this->betScoreGeneratorMock->expects($this->once())->method('generate');

        $score = $this->betCommandHandler->handle($this->betCommandMock);

        $this->assertEquals($this->score, $score);
    }
}
