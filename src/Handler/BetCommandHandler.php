<?php

namespace App\Handler;

use App\Event\AllocateMoneyEvent;
use App\Event\TakeMoneyEvent;
use App\Events;
use App\Generator\BetScoreGeneratorInterface;
use App\Handler\Command\BetCommand;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class BetCommandHandler
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var BetScoreGeneratorInterface
     */
    private $betScoreGenerator;

    /**
     * @param EventDispatcherInterface   $dispatcher
     * @param BetScoreGeneratorInterface $betScoreGenerator
     */
    public function __construct(EventDispatcherInterface $dispatcher, BetScoreGeneratorInterface $betScoreGenerator)
    {
        $this->dispatcher = $dispatcher;
        $this->betScoreGenerator = $betScoreGenerator;
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

        $score = $this->betScoreGenerator->generate($betValue);

        $this->dispatcher->dispatch(
            Events::MONEY_ALLOCATE,
            new AllocateMoneyEvent($user, $score)
        );

        //uzupełnić wartość wagering w bonusowych portfelach i statusy zaktualizować

        return $score;
    }
}
