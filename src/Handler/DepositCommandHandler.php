<?php

namespace App\Handler;

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

        //add bonus
        //allocate money
    }
}
