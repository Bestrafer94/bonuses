<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Bonus;
use App\Entity\Wallet;

class WalletFactory implements WalletFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createRealMoneyWallet(): Wallet
    {
        return (new Wallet())
            ->setStatus(Wallet::STATUS_ACTIVE)
            ->setIsOrigin(true)
            ->setCurrency(Wallet::REAL_MONEY_CURRENCY);
    }

    /**
     * {@inheritdoc}
     */
    public function createBonusMoneyWallet(Bonus $bonus): Wallet
    {
        $valueOfReward = $bonus->getValueOfReward();

        return (new Wallet())
            ->setBonus($bonus)
            ->setCurrentValue($valueOfReward)
            ->setInitialValue($valueOfReward)
            ->setStatus(Wallet::STATUS_ACTIVE)
            ->setIsOrigin(false)
            ->setCurrency(Wallet::BONUS_MONEY_CURRENCY);
    }
}
