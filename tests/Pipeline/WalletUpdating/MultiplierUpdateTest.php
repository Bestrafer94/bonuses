<?php

declare(strict_types=1);

namespace App\Tests\Pipeline\WalletUpdating;

use App\Entity\Bonus;
use App\Entity\Wallet;
use App\Pipeline\WalletUpdating\MultiplierUpdate;
use PHPUnit\Framework\TestCase;

class MultiplierUpdateTest extends TestCase
{
    /**
     * @var MultiplierUpdate
     */
    private $multiplierUpdate;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Wallet
     */
    private $walletMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Bonus
     */
    private $bonusMock;

    /**
     * @var int
     */
    private $betValue = 50;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->walletMock = $this->createMock(Wallet::class);
        $this->bonusMock = $this->createMock(Bonus::class);

        $this->walletMock->method('getBonus')->willReturn($this->bonusMock);

        $this->multiplierUpdate = new MultiplierUpdate($this->betValue);
    }

    public function testInvoke()
    {
        $this->bonusMock->method('getMultiplier')->willReturn(10);
        $this->walletMock->method('getInitialValue')->willReturn(30);

        $this->bonusMock->expects($this->once())->method('setMultiplier');

        $wallet = $this->multiplierUpdate->__invoke($this->walletMock);

        $this->assertInstanceOf(Wallet::class, $wallet);
    }
}
