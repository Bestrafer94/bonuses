<?php

namespace tests\Factory;

use App\Entity\Bonus;
use App\Entity\BonusMoneyWallet;
use App\Entity\RealMoneyWallet;
use App\Factory\WalletFactory;
use App\Factory\WalletFactoryInterface;
use PHPUnit\Framework\TestCase;

class WalletFactoryTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Bonus
     */
    private $bonusMock;

    /**
     * @var WalletFactoryInterface
     */
    private $walletFactory;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->bonusMock = $this->createMock(Bonus::class);
        $this->walletFactory = new WalletFactory();
    }

    public function testCreateRealMoneyWallet()
    {
        $wallet = $this->walletFactory->createRealMoneyWallet();

        $this->assertInstanceOf(RealMoneyWallet::class, $wallet);
    }

    public function testCreateBonusMoneyWallet()
    {
        $valueOfReward = 50;
        $this->bonusMock->method('getValueOfReward')->willReturn($valueOfReward);

        $wallet = $this->walletFactory->createBonusMoneyWallet($this->bonusMock);

        $this->assertInstanceOf(BonusMoneyWallet::class, $wallet);
        $this->assertEquals($valueOfReward, $wallet->getInitialValue());
        $this->assertEquals($valueOfReward, $wallet->getCurrentValue());
        $this->assertEquals(BonusMoneyWallet::BONUS_MONEY_CURRENCY, $wallet->getCurrency());
        $this->assertEquals(BonusMoneyWallet::STATUS_ACTIVE, $wallet->getStatus());
        $this->assertInstanceOf(Bonus::class, $wallet->getBonus());
    }
}
