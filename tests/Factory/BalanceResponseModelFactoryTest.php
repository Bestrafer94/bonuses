<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Bonus;
use App\Entity\User;
use App\Entity\Wallet;
use App\Factory\BalanceResponseModelFactory;
use App\Factory\BalanceResponseModelFactoryInterface;
use App\Model\Response\BalanceResponseModel;
use App\Repository\WalletRepository;
use PHPUnit\Framework\TestCase;

class BalanceResponseModelFactoryTest extends TestCase
{
    const NUMBER_OF_BONUS_WALLETS = 3;
    const BONUS_WALLETS_CURRENT_VALUE = 40;
    const BONUS_NAME = 'name';

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|WalletRepository
     */
    private $walletRepositoryMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|User
     */
    private $userMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Wallet[]
     */
    private $bonusWalletsMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Wallet
     */
    private $walletMock;

    /**
     * @var BalanceResponseModelFactoryInterface
     */
    private $balanceResponseModelFactory;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        for ($i = 0; $i < self::NUMBER_OF_BONUS_WALLETS; ++$i) {
            $walletMock = $this->createMock(Wallet::class);
            $bonusMock = $this->createMock(Bonus::class);
            $bonusMock->method('getName')->willReturn(self::BONUS_NAME);
            $this->bonusWalletsMock[] = $walletMock;
            $walletMock->method('getCurrentValue')->willReturn(self::BONUS_WALLETS_CURRENT_VALUE);
            $walletMock->method('getBonus')->willReturn($bonusMock);
        }

        $this->walletMock = $this->createMock(Wallet::class);
        $this->walletRepositoryMock = $this->createMock(WalletRepository::class);
        $this->userMock = $this->createMock(User::class);
        $this->balanceResponseModelFactory = new BalanceResponseModelFactory($this->walletRepositoryMock);
    }

    public function testCreateDepositBonus()
    {
        $realMoneyCurrentValue = 1000;

        $this->walletMock->method('getCurrentValue')->willReturn($realMoneyCurrentValue);
        $this->walletRepositoryMock->method('findRealMoneyWalletByUser')->willReturn($this->walletMock);
        $this->walletRepositoryMock->method('findActiveBonusMoneyWalletsByUser')->willReturn($this->bonusWalletsMock);

        $response = $this->balanceResponseModelFactory->create($this->userMock);

        $this->assertInstanceOf(BalanceResponseModel::class, $response);
        $this->assertEquals($realMoneyCurrentValue, $response->getRealMoney());
        $this->assertEquals(
            $realMoneyCurrentValue + self::BONUS_WALLETS_CURRENT_VALUE * self::NUMBER_OF_BONUS_WALLETS,
            $response->getTotal()
        );
        $this->assertEquals(
            [
                [
                    BalanceResponseModelFactory::NAME_INDEX => self::BONUS_NAME,
                    BalanceResponseModelFactory::VALUE_INDEX => self::BONUS_WALLETS_CURRENT_VALUE,
                ],
                [
                    BalanceResponseModelFactory::NAME_INDEX => self::BONUS_NAME,
                    BalanceResponseModelFactory::VALUE_INDEX => self::BONUS_WALLETS_CURRENT_VALUE,
                ],
                [
                    BalanceResponseModelFactory::NAME_INDEX => self::BONUS_NAME,
                    BalanceResponseModelFactory::VALUE_INDEX => self::BONUS_WALLETS_CURRENT_VALUE,
                ],
            ],
            $response->getBonuses()
        );
    }
}
