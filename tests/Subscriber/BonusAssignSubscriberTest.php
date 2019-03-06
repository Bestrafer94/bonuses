<?php

declare(strict_types=1);

namespace App\Tests\Subscriber;

use App\Entity\Bonus;
use App\Entity\User;
use App\Entity\Wallet;
use App\Event\DepositBonusAssignEvent;
use App\Factory\BonusFactoryInterface;
use App\Factory\WalletFactoryInterface;
use App\Repository\WalletRepositoryInterface;
use App\Subscriber\BonusAssignSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class BonusAssignSubscriberTest extends TestCase
{
    const NUMBER_OF_WALLETS = 3;

    /**
     * @var BonusAssignSubscriber
     */
    private $bonusAssignSubscriber;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|WalletFactoryInterface
     */
    private $walletFactoryMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|BonusFactoryInterface
     */
    private $bonusFactoryMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|WalletRepositoryInterface
     */
    private $walletRepositoryMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|EntityManagerInterface
     */
    private $entityManagerMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|DepositBonusAssignEvent
     */
    private $depositBonusAssignEventMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|InteractiveLoginEvent
     */
    private $interactiveLoginEventMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|User
     */
    private $userMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->walletFactoryMock = $this->createMock(WalletFactoryInterface::class);
        $this->bonusFactoryMock = $this->createMock(BonusFactoryInterface::class);
        $this->walletRepositoryMock = $this->createMock(WalletRepositoryInterface::class);
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->depositBonusAssignEventMock = $this->createMock(DepositBonusAssignEvent::class);
        $this->interactiveLoginEventMock = $this->createMock(InteractiveLoginEvent::class);
        $this->userMock = $this->createMock(User::class);

        $this->bonusAssignSubscriber = new BonusAssignSubscriber(
            $this->walletFactoryMock,
            $this->bonusFactoryMock,
            $this->walletRepositoryMock,
            $this->entityManagerMock
        );
    }

    public function testOnLoginWithoutLoginBonus()
    {
        for ($i = 0; $i < self::NUMBER_OF_WALLETS; ++$i) {
            $bonusMock = $this->createMock(Bonus::class);
            $walletMock = $this->createMock(Wallet::class);

            $walletMock->method('getBonus')->willReturn($bonusMock);
            $bonusMock->method('getEventTrigger')->willReturn(Bonus::DEPOSIT_TRIGGER);

            $walletsMock[] = $walletMock;
        }
        $authenticationTokenMock = $this->createMock(TokenInterface::class);

        $this->interactiveLoginEventMock->method('getAuthenticationToken')->willReturn($authenticationTokenMock);
        $authenticationTokenMock->method('getUser')->willReturn($this->userMock);
        $this->walletRepositoryMock->method('findActiveBonusMoneyWalletsByUser')->willReturn($walletsMock);

        $this->bonusFactoryMock->expects($this->once())->method('createLoginBonus');
        $this->walletFactoryMock->expects($this->once())->method('createBonusMoneyWallet');
        $this->entityManagerMock->expects($this->once())->method('flush');

        $this->bonusAssignSubscriber->onLogin($this->interactiveLoginEventMock);
    }

    public function testOnLoginWithLoginBonus()
    {
        for ($i = 0; $i < self::NUMBER_OF_WALLETS; ++$i) {
            $bonusMock = $this->createMock(Bonus::class);
            $walletMock = $this->createMock(Wallet::class);

            $walletMock->method('getBonus')->willReturn($bonusMock);
            $bonusMock->method('getEventTrigger')->willReturn(Bonus::LOGIN_TRIGGER);

            $walletsMock[] = $walletMock;
        }
        $authenticationTokenMock = $this->createMock(TokenInterface::class);

        $this->interactiveLoginEventMock->method('getAuthenticationToken')->willReturn($authenticationTokenMock);
        $authenticationTokenMock->method('getUser')->willReturn($this->userMock);
        $this->walletRepositoryMock->method('findActiveBonusMoneyWalletsByUser')->willReturn($walletsMock);

        $this->bonusFactoryMock->expects($this->never())->method('createLoginBonus');
        $this->walletFactoryMock->expects($this->never())->method('createBonusMoneyWallet');
        $this->entityManagerMock->expects($this->never())->method('flush');

        $this->bonusAssignSubscriber->onLogin($this->interactiveLoginEventMock);
    }

    public function testOnDepositWithDepositValueGreaterThanThreshold()
    {
        $this->depositBonusAssignEventMock->method('getUser')->willReturn($this->userMock);
        $this->depositBonusAssignEventMock->method('getDepositValue')->willReturn(1000);

        for ($i = 0; $i < self::NUMBER_OF_WALLETS; ++$i) {
            $walletMock = $this->createMock(Wallet::class);
            $walletMock->method('getInitialValue')->willReturn(200);
            $walletMock->method('getCurrentValue')->willReturn(100);

            $walletsMock[] = $walletMock;
        }

        $this->walletRepositoryMock->method('findActiveBonusMoneyWalletsByUser')->willReturn($walletsMock);

        $this->bonusFactoryMock->expects($this->once())->method('createDepositBonus');
        $this->walletFactoryMock->expects($this->once())->method('createBonusMoneyWallet');
        $this->entityManagerMock->expects($this->once())->method('flush');

        $this->bonusAssignSubscriber->onDeposit($this->depositBonusAssignEventMock);
    }

    public function testOnDepositWithDepositValueLessThanThreshold()
    {
        $this->depositBonusAssignEventMock->method('getUser')->willReturn($this->userMock);
        $this->depositBonusAssignEventMock->method('getDepositValue')->willReturn(100);

        for ($i = 0; $i < self::NUMBER_OF_WALLETS; ++$i) {
            $walletMock = $this->createMock(Wallet::class);
            $walletMock->method('getInitialValue')->willReturn(200);
            $walletMock->method('getCurrentValue')->willReturn(100);

            $walletsMock[] = $walletMock;
        }

        $this->walletRepositoryMock->method('findActiveBonusMoneyWalletsByUser')->willReturn($walletsMock);

        $this->bonusFactoryMock->expects($this->never())->method('createDepositBonus');
        $this->walletFactoryMock->expects($this->never())->method('createBonusMoneyWallet');
        $this->entityManagerMock->expects($this->never())->method('flush');

        $this->bonusAssignSubscriber->onDeposit($this->depositBonusAssignEventMock);
    }
}
