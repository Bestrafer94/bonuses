<?php

namespace App\Handler\Command;

use App\Form\Data\BetData;
use Symfony\Component\Security\Core\User\UserInterface;

class BetCommand
{
    /**
     * @var BetData
     */
    private $betData;

    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @param BetData       $betData
     * @param UserInterface $user
     */
    public function __construct(BetData $betData, UserInterface $user)
    {
        $this->betData = $betData;
        $this->user = $user;
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
    public function getBetValue(): int
    {
        return $this->betData->getBetValue();
    }
}
