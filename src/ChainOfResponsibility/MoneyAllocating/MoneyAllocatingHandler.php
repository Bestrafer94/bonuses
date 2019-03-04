<?php

namespace App\ChainOfResponsibility\MoneyAllocating;

use App\Entity\User;

abstract class MoneyAllocatingHandler implements MoneyAllocatingHandlerInterface
{
    /**
     * @var MoneyAllocatingHandlerInterface
     */
    private $nextHandler;

    /**
     * {@inheritdoc}
     */
    public function setNext(MoneyAllocatingHandlerInterface $moneyAllocatingHandler): MoneyAllocatingHandlerInterface
    {
        $this->nextHandler = $moneyAllocatingHandler;

        return $moneyAllocatingHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(User $user, int $depositValue)
    {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($user, $depositValue);
        }
    }
}
