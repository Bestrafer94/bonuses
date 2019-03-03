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
        foreach ($user->getBonusMoneyWallets() as $bonusMoneyWallet) {
            if (BonusMoneyWallet::STATUS_ACTIVE === $bonusMoneyWallet->getStatus()) {
                $shortAge = $bonusMoneyWallet->getInitialValue() - $bonusMoneyWallet->getCurrentValue();
                if ($shortAge <= $depositValue) {
                    $bonusMoneyWallet->addDepositeMoney($depositValue);
                    $depositValue -= $shortAge;
                } else {
                    $bonusMoneyWallet->addDepositeMoney($depositValue);

                    return 0;
                }
            }
        }

        if (0 !== $depositValue) {
            return parent::handle($user, $depositValue);
        }
    }
}
