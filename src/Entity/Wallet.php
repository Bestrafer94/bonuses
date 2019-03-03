<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WalletRepository")
 */
abstract class Wallet
{
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Wallet
     */
    public function setId(int $id): Wallet
    {
        $this->id = $id;

        return $this;
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
     * @param int $depositMoney
     *
     * @return Wallet
     */
    public function addDepositMoney(int $depositMoney): Wallet
    {
        $this->currentValue += $depositMoney;

        return $this;
    }

    /**
     * @return string
     */
    abstract public function getCurrency(): string;
}
