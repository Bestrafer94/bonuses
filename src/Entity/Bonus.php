<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BonusRepository")
 */
class Bonus
{
    const LOGIN_TRIGGER = 'onLogin';
    const DEPOSIT_TRIGGER = 'onDeposit';

    const DEPOSIT_BONUS_NAME = 'Deposit bonus';
    const LOGIN_BONUS_NAME = 'First login bonus';

    const TRIGGERS = [
        self::LOGIN_TRIGGER,
        self::DEPOSIT_TRIGGER,
    ];

    const BONUS_NAMES = [
        self::LOGIN_BONUS_NAME,
        self::DEPOSIT_BONUS_NAME,
    ];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $multiplier;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $valueOfReward;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @var string
     */
    private $eventTrigger;

    /**
     * @ORM\OneToOne(targetEntity="Wallet", inversedBy="bonus")
     * @ORM\JoinColumn(name="wallet_id", referencedColumnName="id")
     *
     * @var Wallet
     */
    private $wallet;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Bonus
     */
    public function setId(int $id): Bonus
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Bonus
     */
    public function setName(string $name): Bonus
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getMultiplier(): int
    {
        return $this->multiplier;
    }

    /**
     * @param int $multiplier
     *
     * @return Bonus
     */
    public function setMultiplier(int $multiplier): Bonus
    {
        $this->multiplier = $multiplier;

        return $this;
    }

    /**
     * @return int
     */
    public function getValueOfReward(): int
    {
        return $this->valueOfReward;
    }

    /**
     * @param int $valueOfReward
     *
     * @return Bonus
     */
    public function setValueOfReward(int $valueOfReward): Bonus
    {
        $this->valueOfReward = $valueOfReward;

        return $this;
    }

    /**
     * @return string
     */
    public function getEventTrigger(): string
    {
        return $this->eventTrigger;
    }

    /**
     * @param string $eventTrigger
     *
     * @return Bonus
     */
    public function setEventTrigger(string $eventTrigger): Bonus
    {
        $this->eventTrigger = $eventTrigger;

        return $this;
    }

    /**
     * @return Wallet
     */
    public function getWallet(): Wallet
    {
        return $this->wallet;
    }

    /**
     * @param Wallet $wallet
     *
     * @return Bonus
     */
    public function setWallet(Wallet $wallet): Bonus
    {
        $this->wallet = $wallet;

        return $this;
    }
}
