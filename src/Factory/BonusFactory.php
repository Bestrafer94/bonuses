<?php

namespace App\Factory;

use App\Entity\Bonus;

class BonusFactory implements BonusFactoryInterface
{
    const VALUES_OF_REWARD = [10, 20, 40, 50, 80, 100];

    /**
     * {@inheritdoc}
     */
    public function createDepositBonus(int $depositValue): Bonus
    {
        $bonus = new Bonus();

        $bonus->setName(Bonus::DEPOSIT_BONUS_NAME);
        $bonus->setEventTrigger(Bonus::DEPOSIT_TRIGGER);
        $bonus->setMultiplier(rand(1, 100));
        $bonus->setValueOfReward((mt_rand() / mt_getrandmax()) * $depositValue);

        return $bonus;
    }

    /**
     * {@inheritdoc}
     */
    public function createLoginBonus(): Bonus
    {
        $bonus = new Bonus();

        $bonus->setName(Bonus::LOGIN_BONUS_NAME);
        $bonus->setEventTrigger(Bonus::LOGIN_TRIGGER);
        $bonus->setMultiplier(rand(1, 100));
        $bonus->setValueOfReward(self::VALUES_OF_REWARD[rand(0, count(self::VALUES_OF_REWARD) - 1)]);

        return $bonus;
    }
}
