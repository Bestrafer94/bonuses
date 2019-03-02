<?php

namespace App\Factory;

use App\Entity\User;
use App\Model\UserModelInterface;

class UserFactory implements UserFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createUser(UserModelInterface $userModel): User
    {
        return (new User())
            ->setUsername($userModel->getUsername())
            ->setPassword($userModel->getPassword());
    }
}
