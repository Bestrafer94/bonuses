<?php

namespace App\Factory;

use App\Entity\Bonus;

interface BonusFactoryInterface
{
    /**
     * @return Bonus
     */
    public function createDepositBonus(): Bonus;

    /**
     * @return Bonus
     */
    public function createLoginBonus(): Bonus;
}
