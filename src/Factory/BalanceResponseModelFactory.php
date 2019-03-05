<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use App\Entity\Wallet;
use App\Model\Response\BalanceResponseModel;
use App\Repository\WalletRepositoryInterface;

class BalanceResponseModelFactory implements BalanceResponseModelFactoryInterface
{
    const NAME_INDEX = 'name';
    const VALUE_INDEX = 'value';

    /**
     * @var WalletRepositoryInterface
     */
    private $walletRepository;

    /**
     * @param WalletRepositoryInterface $walletRepository
     */
    public function __construct(WalletRepositoryInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function create(User $user): BalanceResponseModel
    {
        /** @var Wallet $realMoneyWallet */
        $realMoneyWallet = $this->walletRepository->findRealMoneyWalletByUser($user);
        $realMoney = $realMoneyWallet->getCurrentValue();
        $bonusWallets = $this->walletRepository->findActiveBonusMoneyWalletsByUser($user);
        $total = 0;
        $bonuses = [];

        /** @var Wallet $bonusWallet */
        foreach ($bonusWallets as $bonusWallet) {
            $currentValue = $bonusWallet->getCurrentValue();
            $total += $currentValue;
            $bonuses[] = [
                self::NAME_INDEX => $bonusWallet->getBonus()->getName(),
                self::VALUE_INDEX => $currentValue,
            ];
        }

        return (new BalanceResponseModel())
            ->setTotal($total + $realMoney)
            ->setRealMoney($realMoney)
            ->setBonuses($bonuses);
    }
}
