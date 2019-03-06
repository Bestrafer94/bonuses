<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\UserProfile;
use App\Handler\Command\UserProfileCommand;
use App\Repository\UserProfileRepositoryInterface;

class UserProfileCommandHandler
{
    /**
     * @var UserProfileRepositoryInterface
     */
    private $userProfileRepository;

    /**
     * @param UserProfileRepositoryInterface $userProfileRepository
     */
    public function __construct(UserProfileRepositoryInterface $userProfileRepository)
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
        return $this->userProfileRepository->findOneByUser($command->getUser());
    }
}
