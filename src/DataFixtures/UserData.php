<?php

namespace App\DataFixtures;

use App\Factory\UserFactoryInterface;
use App\Model\UserModel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class UserData extends Fixture implements OrderedFixtureInterface
{
    const NUMBER_OF_USERS = 10;

    /**
     * @var UserFactoryInterface
     */
    private $userFactory;

    /**
     * @param UserFactoryInterface $userFactory
     */
    public function __construct(UserFactoryInterface $userFactory)
    {
        $this->userFactory = $userFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < self::NUMBER_OF_USERS; ++$i) {
            $createUserModel = (new UserModel())
                ->setUserName(sprintf('user-%s', $i))
                ->setPassword(sprintf('password-%s', $i));

            $user = $this->userFactory->createUser($createUserModel);
            $manager->persist($user);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder(): int
    {
        return 1;
    }
}
