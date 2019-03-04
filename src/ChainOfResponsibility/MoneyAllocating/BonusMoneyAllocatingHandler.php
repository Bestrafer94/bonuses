<?php

namespace App\ChainOfResponsibility\MoneyAllocating;

use App\Entity\BonusMoneyWallet;
use App\Entity\User;

class BonusMoneyAllocatingHandler extends MoneyAllocatingHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(User $user, int $depositValue): int
    {
        /** @var BonusMoneyWallet $bonusMoneyWallet */
        foreach ($user->getBonusMoneyWallets() as $bonusMoneyWallet) {
            if (BonusMoneyWallet::STATUS_ACTIVE === $bonusMoneyWallet->getStatus()) {
                $shortAge = $bonusMoneyWallet->getInitialValue() - $bonusMoneyWallet->getCurrentValue();
                if ($shortAge <= $depositValue && $shortAge > 0) {
                    $bonusMoneyWallet->addDepositMoney($depositValue);
                    $depositValue -= $shortAge;
                } elseif ($shortAge > $depositValue) {
                    $bonusMoneyWallet->addDepositMoney($depositValue);

                    return 0;
                }
            }
        }

        if (0 !== $depositValue) {
            return parent::handle($user, $depositValue);
        }
    }
}
