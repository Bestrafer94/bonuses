<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class TakeMoneyEvent extends Event
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var int
     */
    private $betValue;

    /**
     * @param User $user
     * @param int  $betValue
     */
    public function __construct(User $user, int $betValue)
    {
        $this->user = $user;
        $this->betValue = $betValue;
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
        return $this->betValue;
    }
}
