<?php

namespace App\Factory;

use App\Entity\UserProfile;
use App\Model\UserProfileModerInterface;

class UserProfileFactory implements UserProfileFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createUserProfile(UserProfileModerInterface $userProfileModel): UserProfile
    {
        return (new UserProfile())
            ->setName($userProfileModel->getName())
            ->setLastName($userProfileModel->getLastName())
            ->setGender($userProfileModel->getGender())
            ->setAge($userProfileModel->getAge());
    }
}
