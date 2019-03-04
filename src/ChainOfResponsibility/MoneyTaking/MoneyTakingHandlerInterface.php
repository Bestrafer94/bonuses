<?php

namespace App\ChainOfResponsibility\MoneyTaking;

use App\Entity\User;

interface MoneyTakingHandlerInterface
{
    /**
     * @param MoneyTakingHandlerInterface $moneyTakingHandler
     *
     * @return MoneyTakingHandlerInterface
     */
    public function setNext(MoneyTakingHandlerInterface $moneyTakingHandler): MoneyTakingHandlerInterface;

    /**
     * @param User $user
     * @param int  $betValue
     *
     * @return int
     */
    public function handle(User $user, int $betValue): int;
}
