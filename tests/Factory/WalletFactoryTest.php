<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Bonus;
use App\Entity\Wallet;
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

        $this->assertInstanceOf(Wallet::class, $wallet);
        $this->assertEquals(Wallet::STATUS_ACTIVE, $wallet->getStatus());
        $this->assertEquals(Wallet::REAL_MONEY_CURRENCY, $wallet->getCurrency());
        $this->assertTrue($wallet->isOrigin());
    }

    public function testCreateBonusMoneyWallet()
    {
        $valueOfReward = 50;
        $this->bonusMock->method('getValueOfReward')->willReturn($valueOfReward);

        $wallet = $this->walletFactory->createBonusMoneyWallet($this->bonusMock);

        $this->assertInstanceOf(Wallet::class, $wallet);
        $this->assertEquals($valueOfReward, $wallet->getInitialValue());
        $this->assertEquals($valueOfReward, $wallet->getCurrentValue());
        $this->assertEquals(Wallet::BONUS_MONEY_CURRENCY, $wallet->getCurrency());
        $this->assertEquals(Wallet::STATUS_ACTIVE, $wallet->getStatus());
        $this->assertFalse($wallet->isOrigin());
        $this->assertInstanceOf(Bonus::class, $wallet->getBonus());
    }
}
