<?php

declare(strict_types=1);

namespace App\Tests\ChainOfResponsibility\MoneyTaking;

use App\ChainOfResponsibility\MoneyTaking\RealMoneyTakingHandler;
use App\Entity\User;
use App\Entity\Wallet;
use App\Repository\WalletRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class RealMoneyTakingHandlerTest extends TestCase
{
    /**
     * @var RealMoneyTakingHandler
     */
    private $realMoneyTakingHandler;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|WalletRepositoryInterface
     */
    private $walletRepositoryMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|EntityManagerInterface
     */
    private $entityManagerMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|User
     */
    private $userMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Wallet
     */
    private $walletMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->userMock = $this->createMock(User::class);
        $this->walletMock = $this->createMock(Wallet::class);
        $this->walletRepositoryMock = $this->createMock(WalletRepositoryInterface::class);
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);

        $this->realMoneyTakingHandler = new RealMoneyTakingHandler(
            $this->walletRepositoryMock,
            $this->entityManagerMock
        );
    }

    public function testHandleForCurrentValueGreaterOrEqualBetValue()
    {
        $depositValue = 1000;
        $currentValue = 1500;

        $this->walletRepositoryMock
            ->method('findRealMoneyWalletByUser')
            ->with($this->userMock)
            ->willReturn($this->walletMock);
        $this->walletMock->method('getCurrentValue')->willReturn($currentValue);

        $this->walletMock->expects($this->once())->method('takeMoney')->with($depositValue);
        $this->entityManagerMock->expects($this->once())->method('persist')->with($this->walletMock);
        $this->entityManagerMock->expects($this->once())->method('flush');

        $this->realMoneyTakingHandler->handle($this->userMock, $depositValue);
    }

    public function testHandleForCurrentValueLessThanBetValue()
    {
        $depositValue = 1000;
        $currentValue = 800;

        $this->walletRepositoryMock
            ->method('findRealMoneyWalletByUser')
            ->with($this->userMock)
            ->willReturn($this->walletMock);
        $this->walletMock->method('getCurrentValue')->willReturn($currentValue);

        $this->walletMock->expects($this->once())->method('setCurrentValue')->with(0);
        $this->entityManagerMock->expects($this->once())->method('persist')->with($this->walletMock);
        $this->entityManagerMock->expects($this->never())->method('flush');

        $this->realMoneyTakingHandler->handle($this->userMock, $depositValue);
    }
}
