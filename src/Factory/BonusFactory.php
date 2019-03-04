<?php

namespace App\Factory;

use App\Entity\Bonus;

class BonusFactory implements BonusFactoryInterface
{
    const MULTIPLIER_MIN = 1;
    const MULTIPLIER_MAX = 100;

    const LOGIN_VALUE_OF_REWARD_MIN = 1;
    const LOGIN_VALUE_OF_REWARD_MAX = 100;

    /**
     * {@inheritdoc}
     */
    public function createDepositBonus(int $depositValue): Bonus
    {
        return (new Bonus())
            ->setName(Bonus::DEPOSIT_BONUS_NAME)
            ->setEventTrigger(Bonus::DEPOSIT_TRIGGER)
            ->setMultiplier(rand(self::MULTIPLIER_MIN, self::MULTIPLIER_MAX))
            ->setValueOfReward((mt_rand() / mt_getrandmax()) * $depositValue);
    }

    /**
     * {@inheritdoc}
     */
    public function createLoginBonus(): Bonus
    {
        return (new Bonus())
            ->setName(Bonus::LOGIN_BONUS_NAME)
            ->setEventTrigger(Bonus::LOGIN_TRIGGER)
            ->setMultiplier(rand(self::MULTIPLIER_MIN, self::MULTIPLIER_MAX))
            ->setValueOfReward(rand(self::LOGIN_VALUE_OF_REWARD_MIN, self::LOGIN_VALUE_OF_REWARD_MAX));
    }
}
