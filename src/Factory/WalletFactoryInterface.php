<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Bonus;
use App\Entity\Wallet;

interface WalletFactoryInterface
{
    /**
     * @return Wallet
     */
    public function createRealMoneyWallet(): Wallet;

    /**
     * @param Bonus $bonus
     *
     * @return Wallet
     */
    public function createBonusMoneyWallet(Bonus $bonus): Wallet;
}
