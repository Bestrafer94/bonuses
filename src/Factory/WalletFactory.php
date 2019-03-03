<?php

namespace App\Factory;

use App\Entity\BonusMoneyWallet;
use App\Entity\RealMoneyWallet;

class WalletFactory implements WalletFactoryInterface
{
    /**
     * @return RealMoneyWallet
     */
    public function createRealMoneyWallet(): RealMoneyWallet
    {
        return new RealMoneyWallet();
    }

    /**
     * @return BonusMoneyWallet
     */
    public function createBonusMoneyWallet(): BonusMoneyWallet
    {
        return new BonusMoneyWallet();
    }
}
