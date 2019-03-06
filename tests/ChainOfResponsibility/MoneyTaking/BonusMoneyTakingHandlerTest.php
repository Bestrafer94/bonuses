<?php

declare(strict_types=1);

namespace App\Tests\ChainOfResponsibility\MoneyAllocating;

use App\ChainOfResponsibility\MoneyTaking\BonusMoneyTakingHandler;
use App\Entity\User;
use App\Entity\Wallet;
use App\Exception\NotEnoughMoneyException;
use App\Repository\WalletRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class BonusMoneyTakingHandlerTest extends TestCase
{
    const NUMBER_OF_BONUS_WALLETS = 3;

    /**
     * @var BonusMoneyTakingHandler
     */
    private $bonusMoneyTaking;

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
            $walletMock->method('getCurrentValue')->willReturn(50);
            $this->walletsMock[] = $walletMock;
        }

        $this->walletRepositoryMock
            ->method('findActiveBonusMoneyWalletsByUser')
            ->with($this->userMock)
            ->willReturn($this->walletsMock);

        $this->bonusMoneyTaking = new BonusMoneyTakingHandler(
            $this->walletRepositoryMock,
            $this->entityManagerMock
        );
    }

    public function testHandleForNotEnoughMoney()
    {
        $betValue = 200;

        $this->entityManagerMock->expects($this->exactly(self::NUMBER_OF_BONUS_WALLETS))->method('persist');
        $this->entityManagerMock->expects($this->never())->method('flush');
        $this->expectException(NotEnoughMoneyException::class);

        $this->bonusMoneyTaking->handle($this->userMock, $betValue);
    }

    public function testHandle()
    {
        $betValue = 80;

        $this->entityManagerMock->expects($this->exactly(2))->method('persist');
        $this->entityManagerMock->expects($this->once())->method('flush');

        $this->bonusMoneyTaking->handle($this->userMock, $betValue);
    }
}
