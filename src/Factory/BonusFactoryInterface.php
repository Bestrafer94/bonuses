<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Bonus;

interface BonusFactoryInterface
{
    /**
     * @param int $depositValue
     *
     * @return Bonus
     */
    public function createDepositBonus(int $depositValue): Bonus;

    /**
     * @return Bonus
     */
    public function createLoginBonus(): Bonus;
}
