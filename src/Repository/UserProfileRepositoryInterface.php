<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\UserProfile;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserProfileRepositoryInterface
{
    /**
     * @param UserInterface $user
     *
     * @return UserProfile|null
     */
    public function findOneByUser(UserInterface $user): ?UserProfile;
}
