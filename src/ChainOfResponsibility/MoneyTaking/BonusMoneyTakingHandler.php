<?php

namespace App\ChainOfResponsibility\MoneyTaking;

use App\Entity\User;

class BonusMoneyTakingHandler extends MoneyTakingHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(User $user, int $betValue): int
    {
        if (0 !== $betValue) {
            return parent::handle($user, $betValue);
        }
    }
}
