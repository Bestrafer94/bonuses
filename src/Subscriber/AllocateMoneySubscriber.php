<?php

namespace App\Subscriber;

use App\ChainOfResponsibility\MoneyAllocating\BonusMoneyAllocatingHandler;
use App\ChainOfResponsibility\MoneyAllocating\RealMoneyAllocatingHandler;
use App\Event\AllocateMoneyEvent;
use App\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AllocateMoneySubscriber implements EventSubscriberInterface
{
    /**
     * @var BonusMoneyAllocatingHandler
     */
    private $bonusMoneyAllocatingHandler;

    /**
     * @var RealMoneyAllocatingHandler
     */
    private $realMoneyAllocatingHandler;

    /**
     * @param BonusMoneyAllocatingHandler $bonusMoneyAllocatingHandler
     * @param RealMoneyAllocatingHandler  $realMoneyAllocatingHandler
     */
    public function __construct(
        BonusMoneyAllocatingHandler $bonusMoneyAllocatingHandler,
        RealMoneyAllocatingHandler $realMoneyAllocatingHandler
    ) {
        $this->bonusMoneyAllocatingHandler = $bonusMoneyAllocatingHandler;
        $this->realMoneyAllocatingHandler = $realMoneyAllocatingHandler;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::MONEY_ALLOCATE => 'onMoneyAllocate',
        ];
    }

    /**
     * @param AllocateMoneyEvent $allocateMoneyEvent
     */
    public function onMoneyAllocate(AllocateMoneyEvent $allocateMoneyEvent)
    {
        $user = $allocateMoneyEvent->getUser();
        $depositValue = $allocateMoneyEvent->getDepositValue();

        $this->bonusMoneyAllocatingHandler->setNext($this->realMoneyAllocatingHandler);
        $this->bonusMoneyAllocatingHandler->handle($user, $depositValue);
    }
}
