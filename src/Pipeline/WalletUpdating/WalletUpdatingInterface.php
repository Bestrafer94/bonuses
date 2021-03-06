<?php

declare(strict_types=1);

namespace App\Pipeline\WalletUpdating;

use App\Entity\Wallet;

interface WalletUpdatingInterface
{
    /**
     * @param Wallet $wallet
     *
     * @return Wallet
     */
    public function __invoke(Wallet $wallet): Wallet;
}
