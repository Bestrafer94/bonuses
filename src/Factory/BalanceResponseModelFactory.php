<?php

namespace App\Factory;

use App\Entity\User;
use App\Entity\Wallet;
use App\Model\Response\BalanceResponseModel;
use App\Repository\WalletRepository;

class BalanceResponseModelFactory implements BalanceResponseModelFactoryInterface
{
    const NAME_INDEX = 'name';
    const VALUE_INDEX = 'value';

    /**
     * @var WalletRepository
     */
    private $walletRepository;

    /**
     * @param WalletRepository $walletRepository
     */
    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function create(User $user): BalanceResponseModel
    {
        /** @var Wallet $realMoneyWallet */
        $realMoneyWallet = $this->walletRepository->findOneBy(['user' => $user, 'isOrigin' => true]);
        $realMoney = $realMoneyWallet->getCurrentValue();
        $bonusWallets = $this->walletRepository->findBy(['user' => $user, 'isOrigin' => false]);
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
