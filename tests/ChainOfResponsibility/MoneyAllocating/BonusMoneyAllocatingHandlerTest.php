<?php

declare(strict_types=1);

namespace App\Tests\ChainOfResponsibility\MoneyAllocating;

use App\ChainOfResponsibility\MoneyAllocating\BonusMoneyAllocatingHandler;
use App\Entity\User;
use App\Entity\Wallet;
use App\Repository\WalletRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class BonusMoneyAllocatingHandlerTest extends TestCase
{
    const NUMBER_OF_BONUS_WALLETS = 3;

    /**
     * @var BonusMoneyAllocatingHandler
     */
    private $bonusMoneyAllocatingHandler;

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
     * @var \PHPUnit_Framework_MockObject_MockObject|Wallet[]
     */
    private $walletsMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->userMock = $this->createMock(User::class);
        $this->walletRepositoryMock = $this->createMock(WalletRepositoryInterface::class);
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);

        for ($i = 0; $i < self::NUMBER_OF_BONUS_WALLETS; ++$i) {
            $walletMock = $this->createMock(Wallet::class);
            $walletMock->method('getInitialValue')->willReturn(110);
            $walletMock->method('getCurrentValue')->willReturn(50);
            $walletMock->method('getStatus')->willReturn(Wallet::STATUS_ACTIVE);
            $this->walletsMock[] = $walletMock;
        }

        $this->walletRepositoryMock
            ->method('findBonusMoneyWalletsByUser')
            ->with($this->userMock)
            ->willReturn($this->walletsMock);

        $this->bonusMoneyAllocatingHandler = new BonusMoneyAllocatingHandler(
            $this->walletRepositoryMock,
            $this->entityManagerMock
        );
    }

    public function testHandleForShortageGreaterThanAllocatingValue()
    {
        $depositValue = 150;

        $this->entityManagerMock->expects($this->exactly(self::NUMBER_OF_BONUS_WALLETS))->method('persist');
        $this->entityManagerMock->expects($this->once())->method('flush');

        $this->bonusMoneyAllocatingHandler->handle($this->userMock, $depositValue);
    }

    public function testHandleForShortageLessOrEqualAllocatingValue()
    {
        $depositValue = 190;

        $this->entityManagerMock->expects($this->exactly(self::NUMBER_OF_BONUS_WALLETS))->method('persist');
        $this->entityManagerMock->expects($this->never())->method('flush');

        $this->bonusMoneyAllocatingHandler->handle($this->userMock, $depositValue);
    }
}
