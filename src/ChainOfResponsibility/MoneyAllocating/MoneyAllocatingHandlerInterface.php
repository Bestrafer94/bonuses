<?php

namespace App\ChainOfResponsibility\MoneyAllocating;

use App\Entity\User;

interface MoneyAllocatingHandlerInterface
{
    /**
     * @param MoneyAllocatingHandlerInterface $moneyAllocatingHandler
     *
     * @return MoneyAllocatingHandlerInterface
     */
    public function setNext(MoneyAllocatingHandlerInterface $moneyAllocatingHandler): MoneyAllocatingHandlerInterface;

    /**
     * @param User $user
     * @param int  $depositValue
     *
     * @return int
     */
    public function handle(User $user, int $depositValue): int;
}
