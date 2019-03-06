<?php

namespace App\Pipeline\WalletUpdating;

use App\Entity\Wallet;

class MultiplierUpdate
{
    /**
     * @var int
     */
    private $betValue;

    /**
     * MultiplierUpdate constructor.
     *
     * @param int $betValue
     */
    public function __construct(int $betValue)
    {
        $this->betValue = $betValue;
    }

    /**
     * @param Wallet $wallet
     *
     * @return Wallet
     */
    public function __invoke(Wallet $wallet): Wallet
    {
        $bonus = $wallet->getBonus();
        $bonus->setMultiplier(
            $this->calculateMultiplierValue($bonus->getMultiplier(), $this->betValue, $wallet->getInitialValue())
        );

        return $wallet;
    }

    /**
     * @param int $oldMultiplier
     * @param int $betValue
     * @param int $initialValue
     *
     * @return int
     */
    private function calculateMultiplierValue(int $oldMultiplier, int $betValue, int $initialValue): int
    {
        return (int) ($oldMultiplier - round($betValue / $initialValue));
    }
}