<?php

namespace App\DataFixtures;

use App\Factory\WalletFactoryInterface;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class RealMoneyWalletData extends Fixture implements OrderedFixtureInterface
{
    /**
     * @var WalletFactoryInterface
     */
    private $walletFactory;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param WalletFactoryInterface $walletFactory
     * @param UserRepository         $userRepository
     */
    public function __construct(WalletFactoryInterface $walletFactory, UserRepository $userRepository)
    {
        $this->walletFactory = $walletFactory;
        $this->userRepository = $userRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $users = $this->userRepository->findAll();

        for ($i = 0; $i < UserData::NUMBER_OF_USERS; ++$i) {
            $realMoneyWallet = $this->walletFactory->createRealMoneyWallet();
            $realMoneyWallet->setUser($users[$i]);
            $this->setReference(sprintf('real-money-wallet-%s', $i), $realMoneyWallet);
            $manager->persist($realMoneyWallet);
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
