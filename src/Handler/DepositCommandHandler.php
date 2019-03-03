<?php

namespace App\Handler;

use App\Event\AllocateMoneyEvent;
use App\Event\DepositBonusAssignEvent;
use App\Events;
use App\Handler\Command\DepositCommand;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DepositCommandHandler
{
    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param DepositCommand $command
     */
    public function handle(DepositCommand $command)
    {
        $user = $command->getUser();
        $depositValue = $command->getDepositValue();

        $this->dispatcher->dispatch(
            Events::MONEY_ALLOCATE,
            new AllocateMoneyEvent($user, $depositValue)
        );
        $this->dispatcher->dispatch(
            Events::BONUS_ASSIGN_DEPOSIT,
            new DepositBonusAssignEvent($user, $depositValue)
        );
    }
}
