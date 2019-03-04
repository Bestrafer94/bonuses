<?php

namespace App\ChainOfResponsibility\MoneyTaking;

use App\Entity\BonusMoneyWallet;
use App\Entity\User;

class BonusMoneyTakingHandler extends MoneyTakingHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(User $user, int $betValue): int
    {
        $wallets = $user->getBonusMoneyWallets();

        /** @var BonusMoneyWallet $wallet */
        foreach ($wallets as $wallet) {
            if (BonusMoneyWallet::STATUS_ACTIVE === $wallet->getStatus()) {
                $balance = $wallet->getCurrentValue();
                if ($balance > $betValue) {
                    $wallet->addDepositMoney($betValue * -1);
                    $betValue = 0;
                } else {
                    $wallet->setCurrentValue(0);
                    $wallet->setStatus(BonusMoneyWallet::STATUS_WAGERED);
                    $betValue -= $balance;
                }
            }
        }

        if (0 !== $betValue) {
            return parent::handle($user, $betValue);
        }
    }
}
