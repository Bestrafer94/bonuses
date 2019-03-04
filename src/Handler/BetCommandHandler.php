<?php

namespace App\Handler;

use App\Event\TakeMoneyEvent;
use App\Events;
use App\Handler\Command\BetCommand;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class BetCommandHandler
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
     * @param BetCommand $command
     *
     * @return int
     */
    public function handle(BetCommand $command): int
    {
        $user = $command->getUser();
        $betValue = $command->getBetValue();

        $this->dispatcher->dispatch(
            Events::MONEY_TAKE,
            new TakeMoneyEvent($user, $betValue)
        );

        //odwołać się do serwisu, który wylosuje nagrodę
        //dodać nagrodę do portfeli
        //uzupełnić wartość wagering w bonusowych portfelach
        //zwrócić wartość wygranej

        return 100;
    }
}
