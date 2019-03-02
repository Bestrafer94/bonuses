<?php

namespace App\DataFixtures;

use App\Entity\UserProfile;
use App\Factory\UserProfileFactoryInterface;
use App\Model\UserProfileModel;
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
     * @param UserProfileFactoryInterface $userProfileFactory
     */
    public function __construct(UserProfileFactoryInterface $userProfileFactory)
    {
        $this->userProfileFactory = $userProfileFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $genders = UserProfile::GENDERS;

        for ($i = 0; $i < UserData::NUMBER_OF_USERS; ++$i) {
            $createUserModel = (new UserProfileModel())
                ->setName(sprintf('firstName-%s', $i))
                ->setLastName(sprintf('lastName-%s', $i))
                ->setGender($genders[rand(0, count($genders) - 1)])
                ->setAge(rand(18, 100));

            $user = $this->userProfileFactory->createUserProfile($createUserModel);
            $manager->persist($user);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder(): int
    {
        return 0;
    }
}
