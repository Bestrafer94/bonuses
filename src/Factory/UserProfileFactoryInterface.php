<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\UserProfile;
use App\Model\UserProfileModerInterface;

interface UserProfileFactoryInterface
{
    /**
     * @param UserProfileModerInterface $userProfileModel
     *
     * @return UserProfile
     */
    public function createUserProfile(UserProfileModerInterface $userProfileModel): UserProfile;
}
