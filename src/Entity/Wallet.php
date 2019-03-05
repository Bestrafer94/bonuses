<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WalletRepository")
 */
class Wallet
{
    const REAL_MONEY_CURRENCY = 'EUR';
    const BONUS_MONEY_CURRENCY = 'BNS';

    const STATUS_ACTIVE = 'active';
    const STATUS_WAGERED = 'wagered';
    const STATUS_DEPLETED = 'depleted';

    const CURRENCIES = [
        self::REAL_MONEY_CURRENCY,
        self::BONUS_MONEY_CURRENCY,
    ];

    const STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_WAGERED,
        self::STATUS_DEPLETED,
    ];

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $currentValue = 0;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $initialValue = 0;

    /**
     * @ORM\Column(type="string", length=10)
     *
     * @var string
     */
    private $status;

    /**
     * @ORM\OneToOne(targetEntity="Bonus", mappedBy="wallet", cascade={"persist"})
     *
     * @var Bonus|null
     */
    private $bonus;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $isOrigin;

    /**
     * @ORM\Column(type="string", length=10)
     *
     * @var string
     */
    private $currency;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCurrentValue(): int
    {
        return $this->currentValue;
    }

    /**
     * @param int $currentValue
     *
     * @return Wallet
     */
    public function setCurrentValue(int $currentValue): Wallet
    {
        $this->currentValue = $currentValue;

        return $this;
    }

    /**
     * @return int
     */
    public function getInitialValue(): int
    {
        return $this->initialValue;
    }

    /**
     * @param int $initialValue
     *
     * @return Wallet
     */
    public function setInitialValue(int $initialValue): Wallet
    {
        $this->initialValue = $initialValue;

        return $this;
    }

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
     * @return Wallet
     */
    public function setStatus(string $status): Wallet
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Bonus|null
     */
    public function getBonus(): ?Bonus
    {
        return $this->bonus;
    }

    /**
     * @param Bonus|null $bonus
     *
     * @return Wallet
     */
    public function setBonus(?Bonus $bonus): Wallet
    {
        $this->bonus = $bonus;
        $bonus->setWallet($this);

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return Wallet
     */
    public function setUser(User $user): Wallet
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOrigin(): bool
    {
        return $this->isOrigin;
    }

    /**
     * @param bool $isOrigin
     *
     * @return Wallet
     */
    public function setIsOrigin(bool $isOrigin): Wallet
    {
        $this->isOrigin = $isOrigin;

        return $this;
    }

    /**
     * @param int $money
     *
     * @return Wallet
     */
    public function addMoney(int $money): Wallet
    {
        $this->currentValue += $money;

        return $this;
    }

    /**
     * @param int $money
     *
     * @return Wallet
     */
    public function takeMoney(int $money): Wallet
    {
        $this->currentValue -= $money;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return Wallet
     */
    public function setCurrency(string $currency): Wallet
    {
        $this->currency = $currency;

        return $this;
    }
}
