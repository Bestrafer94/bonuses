<?php

declare(strict_types=1);

namespace App\Subscriber;

use App\ChainOfResponsibility\MoneyTaking\BonusMoneyTakingHandler;
use App\ChainOfResponsibility\MoneyTaking\RealMoneyTakingHandler;
use App\Event\TakeMoneyEvent;
use App\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TakeMoneySubscriber implements EventSubscriberInterface
{
    /**
     * @var BonusMoneyTakingHandler
     */
    private $bonusMoneyTakingHandler;

    /**
     * @var RealMoneyTakingHandler
     */
    private $realMoneyTakingHandler;

    /**
     * @param BonusMoneyTakingHandler $bonusMoneyTakingHandler
     * @param RealMoneyTakingHandler  $realMoneyTakingHandler
     */
    public function __construct(BonusMoneyTakingHandler $bonusMoneyTakingHandler, RealMoneyTakingHandler $realMoneyTakingHandler)
    {
        $this->bonusMoneyTakingHandler = $bonusMoneyTakingHandler;
        $this->realMoneyTakingHandler = $realMoneyTakingHandler;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::MONEY_TAKE => 'onMoneyTake',
        ];
    }

    /**
     * @param TakeMoneyEvent $takeMoneyEvent
     */
    public function onMoneyTake(TakeMoneyEvent $takeMoneyEvent)
    {
        $user = $takeMoneyEvent->getUser();
        $depositValue = $takeMoneyEvent->getBetValue();

        $this->realMoneyTakingHandler->setNext($this->bonusMoneyTakingHandler);
        $this->realMoneyTakingHandler->handle($user, $depositValue);
    }
}
