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
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @var User
     */
    private $user;

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
     * @return RealMoneyWallet
     */
    public function setUser(User $user): RealMoneyWallet
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return self::REAL_MONEY_CURRENCY;
    }
}
