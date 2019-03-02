<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LoginBonusRepository")
 */
class LoginBonus extends Bonus
{
    const TRIGGER = 'onLogin';

    /**
     * @return string
     */
    public function getTrigger(): string
    {
        return self::TRIGGER;
    }
}
