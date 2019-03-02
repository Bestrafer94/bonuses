<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepositBonusRepository")
 */
class DepositBonus extends Bonus
{
    const TRIGGER = 'onDeposit';

    /**
     * @return string
     */
    public function getTrigger(): string
    {
        return self::TRIGGER;
    }
}
