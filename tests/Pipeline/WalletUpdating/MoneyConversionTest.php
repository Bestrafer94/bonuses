<?php

declare(strict_types=1);

namespace App\Tests\Pipeline\WalletUpdating;

use App\Entity\Bonus;
use App\Entity\User;
use App\Entity\Wallet;
use App\Pipeline\WalletUpdating\MoneyConversion;
use App\Repository\WalletRepositoryInterface;
use PHPUnit\Framework\TestCase;

class MoneyConversionTest extends TestCase
{
    /**
     * @var MoneyConversion
     */
    private $moneyConversion;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|WalletRepositoryInterface
     */
    private $walletRepositoryMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|User
     */
    private $userMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Wallet
     */
    private $walletMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Bonus
     */
    private $bonusMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Wallet
     */
    private $realMoneyWalletMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->userMock = $this->createMock(User::class);
        $this->bonusMock = $this->createMock(Bonus::class);
        $this->walletMock = $this->createMock(Wallet::class);
        $this->realMoneyWalletMock = $this->createMock(Wallet::class);
        $this->walletRepositoryMock = $this->createMock(WalletRepositoryInterface::class);

        $this->walletMock->method('getBonus')->willReturn($this->bonusMock);
        $this->walletRepositoryMock->method('findRealMoneyWalletByUser')->willReturn($this->realMoneyWalletMock);

        $this->moneyConversion = new MoneyConversion($this->walletRepositoryMock, $this->userMock);
    }

    public function testInvokeForMultiplierGreaterThanZero()
    {
        $this->bonusMock->method('getMultiplier')->willReturn(10);

        $this->realMoneyWalletMock->expects($this->never())->method('addMoney');
        $this->walletMock->expects($this->never())->method('setStatus');
        $wallet = $this->moneyConversion->__invoke($this->walletMock);

        $this->assertInstanceOf(Wallet::class, $wallet);
    }

    public function testInvokeForMultiplierLessOrEqualZero()
    {
        $this->bonusMock->method('getMultiplier')->willReturn(0);

        $this->realMoneyWalletMock->expects($this->once())->method('addMoney');
        $this->walletMock->expects($this->once())->method('setStatus');
        $wallet = $this->moneyConversion->__invoke($this->walletMock);

        $this->assertInstanceOf(Wallet::class, $wallet);
    }
}
