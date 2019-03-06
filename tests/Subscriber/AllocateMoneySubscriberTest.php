<?php

declare(strict_types=1);

namespace App\Tests\Subscriber;

use App\ChainOfResponsibility\MoneyAllocating\BonusMoneyAllocatingHandler;
use App\ChainOfResponsibility\MoneyAllocating\RealMoneyAllocatingHandler;
use App\Entity\User;
use App\Event\AllocateMoneyEvent;
use App\Subscriber\AllocateMoneySubscriber;
use PHPUnit\Framework\TestCase;

class AllocateMoneySubscriberTest extends TestCase
{
    /**
     * @var AllocateMoneySubscriber
     */
    private $allocateMoneySubscriber;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|BonusMoneyAllocatingHandler
     */
    private $bonusMoneyAllocatingHandlerMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|RealMoneyAllocatingHandler
     */
    private $realMoneyAllocatingHandlerMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|AllocateMoneyEvent
     */
    private $allocateMoneyEventMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|User
     */
    private $userMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->bonusMoneyAllocatingHandlerMock = $this->createMock(BonusMoneyAllocatingHandler::class);
        $this->realMoneyAllocatingHandlerMock = $this->createMock(RealMoneyAllocatingHandler::class);
        $this->allocateMoneyEventMock = $this->createMock(AllocateMoneyEvent::class);
        $this->userMock = $this->createMock(User::class);

        $this->allocateMoneyEventMock->method('getUser')->willReturn($this->userMock);

        $this->allocateMoneySubscriber = new AllocateMoneySubscriber(
            $this->bonusMoneyAllocatingHandlerMock,
            $this->realMoneyAllocatingHandlerMock
        );
    }

    public function testOnMoneyAllocate()
    {
        $this->bonusMoneyAllocatingHandlerMock->expects($this->once())->method('setNext');
        $this->bonusMoneyAllocatingHandlerMock->expects($this->once())->method('handle');

        $this->allocateMoneySubscriber->onMoneyAllocate($this->allocateMoneyEventMock);
    }
}
