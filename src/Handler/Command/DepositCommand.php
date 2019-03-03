<?php

namespace App\Handler\Command;

use Symfony\Component\Security\Core\User\UserInterface;
use App\Form\Data\DepositData;

class DepositCommand
{
    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @var DepositData
     */
    private $depositData;

    /**
     * @param UserInterface $user
     * @param DepositData   $depositValue
     */
    public function __construct(DepositData $depositData, UserInterface $user)
    {
        $this->user = $user;
        $this->depositData = $depositData;
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
        return $this->depositData->getDepositValue();
    }
}
