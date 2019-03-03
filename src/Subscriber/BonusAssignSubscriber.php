<?php

namespace App\Subscriber;

use App\Event\DepositBonusAssignEvent;
use App\Event\LoginBonusAssignEvent;
use App\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BonusAssignSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::BONUS_ASSIGN_DEPOSIT => 'onDeposit',
            Events::BONUS_ASSIGN_LOGIN => 'onLogin',
        ];
    }

    /**
     * @param DepositBonusAssignEvent $depositBonusAssignEvent
     */
    public function onDeposit(DepositBonusAssignEvent $depositBonusAssignEvent)
    {
    }

    /**
     * @param LoginBonusAssignEvent $loginBonusAssignEvent
     */
    public function onLogin(LoginBonusAssignEvent $loginBonusAssignEvent)
    {
    }
}
