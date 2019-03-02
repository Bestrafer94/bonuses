<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BonusMoneyWalletRepository")
 */
class BonusMoneyWallet extends Wallet
{
    const BONUS_MONEY_CURRENCY = 'BNS';

    const STATUS_ACTIVE = 'active';
    const STATUS_WAGERED = 'wagered';
    const STATUS_DEPLETED = 'depleted';

    const STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_WAGERED,
        self::STATUS_DEPLETED,
    ];

    /**
     * @ORM\Column(type="string", length=10)
     *
     * @var string
     */
    private $status;

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return BonusMoneyWallet
     */
    public function setStatus(string $status): BonusMoneyWallet
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return self::BONUS_MONEY_CURRENCY;
    }
}
