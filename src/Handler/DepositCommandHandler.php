<?php

namespace App\Handler;

use App\ChainOfResponsibility\MoneyAllocating\BonusMoneyAllocatingHandler;
use App\ChainOfResponsibility\MoneyAllocating\RealMoneyAllocatingHandler;
use App\Handler\Command\DepositCommand;
use Symfony\Component\Security\Core\User\UserInterface;

class DepositCommandHandler
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
     * @param DepositCommand $command
     */
    public function handle(DepositCommand $command)
    {
        $user = $command->getUser();
        $depositValue = $command->getDepositValue();

        $this->allocateMoney($user, $depositValue);
        $this->addBonus($user, $depositValue);
    }

    /**
     * @param UserInterface $user
     * @param int           $depositValue
     */
    private function allocateMoney(UserInterface $user, int $depositValue)
    {
        $this->bonusMoneyAllocatingHandler->setNext($this->realMoneyAllocatingHandler);
        $this->bonusMoneyAllocatingHandler->handle($user, $depositValue);
    }

    /**
     * @param UserInterface $user
     * @param int           $depositValue
     */
    private function addBonus(UserInterface $user, int $depositValue)
    {
    }
}
