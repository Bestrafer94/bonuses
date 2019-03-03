<?php

namespace tests\Factory;

use App\Entity\BonusMoneyWallet;
use App\Entity\RealMoneyWallet;
use App\Factory\WalletFactory;
use App\Factory\WalletFactoryInterface;
use PHPUnit\Framework\TestCase;

class WalletFactoryTest extends TestCase
{
    /**
     * @var WalletFactoryInterface
     */
    private $walletFactory;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->walletFactory = new WalletFactory();
    }

    public function testCreateRealMoneyWallet()
    {
        $wallet = $this->walletFactory->createRealMoneyWallet();

        $this->assertInstanceOf(RealMoneyWallet::class, $wallet);
    }

    public function testCreateBonusMoneyWallet()
    {
        $wallet = $this->walletFactory->createBonusMoneyWallet();

        $this->assertInstanceOf(BonusMoneyWallet::class, $wallet);
    }
}
