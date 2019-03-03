<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\User\UserInterface;

class AllocateMoneyEvent extends Event
{
    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @var int
     */
    private $depositValue;

    /**
     * @param UserInterface $user
     * @param int           $depositValue
     */
    public function __construct(UserInterface $user, int $depositValue)
    {
        $this->user = $user;
        $this->depositValue = $depositValue;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function getDepositValue(): int
    {
        return $this->depositValue;
    }
}
