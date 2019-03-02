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
     * @ORM\OneToOne(targetEntity="App\Entity\Bonus", cascade={"remove"})
     * @ORM\JoinColumn(name="bonus_id", referencedColumnName="id")
     *
     * @var Bonus
     */
    private $bonus;

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
     * @return Bonus
     */
    public function getBonus(): Bonus
    {
        return $this->bonus;
    }

    /**
     * @param Bonus $bonus
     *
     * @return BonusMoneyWallet
     */
    public function setBonus(Bonus $bonus): BonusMoneyWallet
    {
        $this->bonus = $bonus;

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
