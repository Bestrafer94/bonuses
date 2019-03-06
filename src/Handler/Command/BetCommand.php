<?php

declare(strict_types=1);

namespace App\Handler\Command;

use App\Entity\User;
use App\Form\Data\BetData;

class BetCommand
{
    /**
     * @var BetData
     */
    private $betData;

    /**
     * @var User
     */
    private $user;

    /**
     * @param BetData $betData
     * @param User    $user
     */
    public function __construct(BetData $betData, User $user)
    {
        $this->betData = $betData;
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function getBetValue(): int
    {
        return $this->betData->getBetValue();
    }
}
