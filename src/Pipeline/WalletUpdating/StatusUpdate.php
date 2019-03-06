<?php

namespace App\Pipeline\WalletUpdating;

use App\Entity\Wallet;

class StatusUpdate implements WalletUpdatingInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(Wallet $wallet): Wallet
    {
        if (Wallet::STATUS_WAGERED === $wallet->getStatus() && 0 === $wallet->getCurrentValue()) {
            $wallet->setStatus(Wallet::STATUS_DEPLETED);
        } elseif (Wallet::STATUS_WAGERED === $wallet->getStatus() && 0 !== $wallet->getCurrentValue()) {
            $wallet->setStatus(Wallet::STATUS_ACTIVE);
        }

        return $wallet;
    }
}
