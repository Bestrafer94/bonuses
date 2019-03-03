<?php

namespace App\Event;

use Symfony\Component\Security\Core\User\UserInterface;

class DepositBonusAssignEvent extends BonusAssignEvent
{
    /**
     * @var int
     */
    protected $depositValue;

    /**
     * @param UserInterface $user
     * @param int           $depositValue
     */
    public function __construct(UserInterface $user, int $depositValue)
    {
        parent::__construct($user);
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
