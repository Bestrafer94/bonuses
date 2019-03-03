<?php

namespace App\Factory;

use App\Entity\Bonus;
use App\Entity\BonusMoneyWallet;
use App\Entity\RealMoneyWallet;

class WalletFactory implements WalletFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createRealMoneyWallet(): RealMoneyWallet
    {
        return new RealMoneyWallet();
    }

    /**
     * {@inheritdoc}
     */
    public function createBonusMoneyWallet(Bonus $bonus): BonusMoneyWallet
    {
        $valueOfReward = $bonus->getValueOfReward();

        $wallet = new BonusMoneyWallet();
        $wallet->setBonus($bonus);
        $wallet->setCurrentValue($valueOfReward);
        $wallet->setInitialValue($valueOfReward);
        $wallet->setStatus(BonusMoneyWallet::STATUS_ACTIVE);

        return $wallet;
    }
}
