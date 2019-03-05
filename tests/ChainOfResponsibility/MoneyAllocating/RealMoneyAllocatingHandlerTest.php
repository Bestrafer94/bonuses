<?php

declare(strict_types=1);

namespace App\Tests\ChainOfResponsibility\MoneyAllocating;

use App\ChainOfResponsibility\MoneyAllocating\RealMoneyAllocatingHandler;
use App\Entity\User;
use App\Entity\Wallet;
use App\Repository\WalletRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class RealMoneyAllocatingHandlerTest extends TestCase
{
    /**
     * @var RealMoneyAllocatingHandler
     */
    private $realMoneyAllocatingHandler;

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

        $this->realMoneyAllocatingHandler = new RealMoneyAllocatingHandler(
            $this->walletRepositoryMock,
            $this->entityManagerMock
        );
    }

    public function testHandle()
    {
        $depositValue = 1000;

        $this->walletRepositoryMock
            ->method('findRealMoneyWalletByUser')
            ->with($this->userMock)
            ->willReturn($this->walletMock);

        $this->walletRepositoryMock->expects($this->once())->method('findRealMoneyWalletByUser');
        $this->walletMock->expects($this->once())->method('addMoney')->with($depositValue);
        $this->entityManagerMock->expects($this->once())->method('persist')->with($this->walletMock);
        $this->entityManagerMock->expects($this->once())->method('flush');

        $this->realMoneyAllocatingHandler->handle($this->userMock, $depositValue);
    }
}
