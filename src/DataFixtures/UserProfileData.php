<?php

namespace App\DataFixtures;

use App\Entity\UserProfile;
use App\Factory\UserProfileFactoryInterface;
use App\Model\UserProfileModel;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class UserProfileData extends Fixture implements OrderedFixtureInterface
{
    /**
     * @var UserProfileFactoryInterface
     */
    private $userProfileFactory;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param UserProfileFactoryInterface $userProfileFactory
     * @param UserRepository              $userRepository
     */
    public function __construct(UserProfileFactoryInterface $userProfileFactory, UserRepository $userRepository)
    {
        $this->userProfileFactory = $userProfileFactory;
        $this->userRepository = $userRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $genders = UserProfile::GENDERS;
        $users = $this->userRepository->findAll();

        for ($i = 0; $i < UserData::NUMBER_OF_USERS; ++$i) {
            $createUserModel = (new UserProfileModel())
                ->setName(sprintf('firstName-%s', $i))
                ->setLastName(sprintf('lastName-%s', $i))
                ->setGender($genders[rand(0, count($genders) - 1)])
                ->setAge(rand(18, 100));

            $userProfile = $this->userProfileFactory->createUserProfile($createUserModel);
            $userProfile->setUser($users[$i]);
            $manager->persist($userProfile);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder(): int
    {
        return 2;
    }
}
