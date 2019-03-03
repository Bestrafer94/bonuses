<?php

namespace App\Factory;

use App\Entity\BonusMoneyWallet;
use App\Entity\RealMoneyWallet;

interface WalletFactoryInterface
{
    /**
     * @return RealMoneyWallet
     */
    public function createRealMoneyWallet(): RealMoneyWallet;

    /**
     * @return BonusMoneyWallet
     */
    public function createBonusMoneyWallet(): BonusMoneyWallet;
}
