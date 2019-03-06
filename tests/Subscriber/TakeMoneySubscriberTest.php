<?php

declare(strict_types=1);

namespace App\Tests\Subscriber;

use App\ChainOfResponsibility\MoneyTaking\BonusMoneyTakingHandler;
use App\ChainOfResponsibility\MoneyTaking\RealMoneyTakingHandler;
use App\Entity\User;
use App\Event\TakeMoneyEvent;
use App\Subscriber\TakeMoneySubscriber;
use PHPUnit\Framework\TestCase;

class takeMoneySubscriberTest extends TestCase
{
    /**
     * @var TakeMoneySubscriber
     */
    private $takeMoneySubscriber;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|BonusMoneyTakingHandler
     */
    private $bonusMoneyTakingHandlerMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|RealMoneyTakingHandler
     */
    private $realMoneyTakingHandlerMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|TakeMoneyEvent
     */
    private $takeMoneyEventMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|User
     */
    private $userMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->bonusMoneyTakingHandlerMock = $this->createMock(BonusMoneyTakingHandler::class);
        $this->realMoneyTakingHandlerMock = $this->createMock(RealMoneyTakingHandler::class);
        $this->takeMoneyEventMock = $this->createMock(TakeMoneyEvent::class);
        $this->userMock = $this->createMock(User::class);

        $this->takeMoneyEventMock->method('getUser')->willReturn($this->userMock);

        $this->takeMoneySubscriber = new TakeMoneySubscriber(
            $this->bonusMoneyTakingHandlerMock,
            $this->realMoneyTakingHandlerMock
        );
    }

    public function testOnMoneyTake()
    {
        $this->realMoneyTakingHandlerMock->expects($this->once())->method('setNext');
        $this->realMoneyTakingHandlerMock->expects($this->once())->method('handle');

        $this->takeMoneySubscriber->onMoneyTake($this->takeMoneyEventMock);
    }
}
