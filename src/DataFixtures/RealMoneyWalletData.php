<?php

namespace App\DataFixtures;

use App\Factory\WalletFactoryInterface;
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
     * @param WalletFactoryInterface $walletFactory
     */
    public function __construct(WalletFactoryInterface $walletFactory)
    {
        $this->walletFactory = $walletFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < UserData::NUMBER_OF_USERS; ++$i) {
            $realMoneyWallet = $this->walletFactory->createRealMoneyWallet();
            $manager->persist($realMoneyWallet);
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
