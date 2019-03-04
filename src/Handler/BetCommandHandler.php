<?php

namespace App\Handler;

use App\ChainOfResponsibility\MoneyTaking\BonusMoneyTakingHandler;
use App\ChainOfResponsibility\MoneyTaking\RealMoneyTakingHandler;
use App\Handler\Command\BetCommand;
use Symfony\Component\Security\Core\User\UserInterface;

class BetCommandHandler
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
     * @param BetCommand $command
     */
    public function handle(BetCommand $command): int
    {
        $user = $command->getUser();
        $betValue = $command->getBetValue();

        //zabierz z portfeli betValue
        //odwołać się do serwisu, który wylosuje nagrodę
        //dodać nagrodę do portfeli
        //uzupełnić wartość wagering w bonusowych portfelach
        //zwrócić wartość wygranej

        return 100;
    }

    /**
     * @param UserInterface $user
     * @param int           $betValue
     */
    private function takeMoney(UserInterface $user, int $betValue)
    {
        $this->realMoneyTakingHandler->setNext($this->bonusMoneyTakingHandler);
        $this->realMoneyTakingHandler->handle($user, $betValue);
    }
}
