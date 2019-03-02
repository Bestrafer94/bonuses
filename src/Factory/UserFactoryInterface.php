<?php

namespace App\Factory;

use App\Model\UserModelInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserFactoryInterface
{
    /**
     * @param UserModelInterface $userModel
     *
     * @return UserInterface
     */
    public function createUser(UserModelInterface $userModel): User;
}
