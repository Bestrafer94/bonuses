<?php

namespace App\Factory;

use App\Entity\Bonus;
use App\Entity\BonusMoneyWallet;
use App\Entity\RealMoneyWallet;

interface WalletFactoryInterface
{
    /**
     * @return RealMoneyWallet
     */
    public function createRealMoneyWallet(): RealMoneyWallet;

    /**
     * @param Bonus $bonus
     *
     * @return BonusMoneyWallet
     */
    public function createBonusMoneyWallet(Bonus $bonus): BonusMoneyWallet;
}
