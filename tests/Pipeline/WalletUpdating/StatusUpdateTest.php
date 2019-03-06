<?php

declare(strict_types=1);

namespace App\Tests\Pipeline\WalletUpdating;

use App\Entity\Wallet;
use App\Pipeline\WalletUpdating\StatusUpdate;
use PHPUnit\Framework\TestCase;

class StatusUpdateTest extends TestCase
{
    /**
     * @var StatusUpdate
     */
    private $statusUpdate;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Wallet
     */
    private $walletMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->walletMock = $this->createMock(Wallet::class);

        $this->statusUpdate = new StatusUpdate();
    }

    public function testInvokeForNoChangeStatus()
    {
        $this->walletMock->method('getStatus')->willReturn(Wallet::STATUS_ACTIVE);
        $this->walletMock->method('getCurrentValue')->willReturn(50);

        $this->walletMock->expects($this->never())->method('setStatus');

        $wallet = $this->statusUpdate->__invoke($this->walletMock);

        $this->assertInstanceOf(Wallet::class, $wallet);
    }

    public function testInvokeForChangeStatusOnDepleted()
    {
        $this->walletMock->method('getStatus')->willReturn(Wallet::STATUS_WAGERED);
        $this->walletMock->method('getCurrentValue')->willReturn(0);

        $this->walletMock->expects($this->once())->method('setStatus')->with(Wallet::STATUS_DEPLETED);

        $wallet = $this->statusUpdate->__invoke($this->walletMock);

        $this->assertInstanceOf(Wallet::class, $wallet);
    }

    public function testInvokeForChangeStatusOnActive()
    {
        $this->walletMock->method('getStatus')->willReturn(Wallet::STATUS_WAGERED);
        $this->walletMock->method('getCurrentValue')->willReturn(50);

        $this->walletMock->expects($this->once())->method('setStatus')->with(Wallet::STATUS_ACTIVE);

        $wallet = $this->statusUpdate->__invoke($this->walletMock);

        $this->assertInstanceOf(Wallet::class, $wallet);
    }
}
