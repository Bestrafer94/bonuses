<?php

namespace App\DataFixtures;

use App\Factory\UserFactoryInterface;
use App\Model\UserModel;
use App\Repository\RealMoneyWalletRepository;
use App\Repository\UserProfileRepository;
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
     * @var UserProfileRepository
     */
    private $userProfileRepository;

    /**
     * @var RealMoneyWalletRepository
     */
    private $realMoneyWalletRepository;

    /**
     * @param UserFactoryInterface      $userFactory
     * @param UserProfileRepository     $userProfileRepository
     * @param RealMoneyWalletRepository $realMoneyWalletRepository
     */
    public function __construct(
        UserFactoryInterface $userFactory,
        UserProfileRepository $userProfileRepository,
        RealMoneyWalletRepository $realMoneyWalletRepository
    ) {
        $this->userFactory = $userFactory;
        $this->userProfileRepository = $userProfileRepository;
        $this->realMoneyWalletRepository = $realMoneyWalletRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $userProfiles = $this->userProfileRepository->findAll();
        $realMoneyWallets = $this->realMoneyWalletRepository->findAll();

        for ($i = 0; $i < self::NUMBER_OF_USERS; ++$i) {
            $createUserModel = (new UserModel())
                ->setUserName(sprintf('user-%s', $i))
                ->setPassword(sprintf('password-%s', $i));

            $user = $this->userFactory->createUser($createUserModel)
                ->setProfile($userProfiles[$i])
                ->setRealMoneyWallet($realMoneyWallets[$i]);

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
