<?php

namespace App\ChainOfResponsibility\MoneyTaking;

use App\Entity\User;

abstract class MoneyTakingHandler implements MoneyTakingHandlerInterface
{
    /**
     * @var MoneyTakingHandlerInterface
     */
    private $nextHandler;

    /**
     * {@inheritdoc}
     */
    public function setNext(MoneyTakingHandlerInterface $moneyTakingHandler): MoneyTakingHandlerInterface
    {
        $this->nextHandler = $moneyTakingHandler;

        return $moneyTakingHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(User $user, int $beValue): int
    {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($user, $beValue);
        }

        return 0;
    }
}
