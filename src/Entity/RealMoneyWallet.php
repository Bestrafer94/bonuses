<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RealMoneyWalletRepository")
 */
class RealMoneyWallet extends Wallet
{
    const REAL_MONEY_CURRENCY = 'EUR';

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return self::REAL_MONEY_CURRENCY;
    }
}
