<?php

namespace App\Handler;

use App\Entity\UserProfile;
use App\Handler\Command\UserProfileCommand;
use App\Repository\UserProfileRepository;

class UserProfileCommandHandler
{
    /**
     * @var UserProfileRepository
     */
    private $userProfileRepository;

    /**
     * @param UserProfileRepository $userProfileRepository
     */
    public function __construct(UserProfileRepository $userProfileRepository)
    {
        $this->userProfileRepository = $userProfileRepository;
    }

    /**
     * @param UserProfileCommand $command
     *
     * @return UserProfile|null
     */
    public function handle(UserProfileCommand $command): ?UserProfile
    {
        return $this->userProfileRepository->findOneBy(['user' => $command->getUser()]);
    }
}
