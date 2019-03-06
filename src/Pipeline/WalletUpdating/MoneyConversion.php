<?php

namespace App\Pipeline\WalletUpdating;

use App\Entity\User;
use App\Entity\Wallet;
use App\Repository\WalletRepositoryInterface;

class MoneyConversion implements WalletUpdatingInterface
{
    /**
     * @var WalletRepositoryInterface
     */
    private $walletRepository;

    /**
     * @var User
     */
    private $user;

    /**
     * @param WalletRepositoryInterface $walletRepository
     * @param User                      $user
     */
    public function __construct(WalletRepositoryInterface $walletRepository, User $user)
    {
        $this->walletRepository = $walletRepository;
        $this->user = $user;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(Wallet $wallet): Wallet
    {
        if ($wallet->getBonus()->getMultiplier() <= 0) {
            /** @var Wallet $realMoneyWallet */
            $realMoneyWallet = $this->walletRepository->findRealMoneyWalletByUser($this->user);
            $realMoneyWallet->addMoney($wallet->getInitialValue());
            $wallet->setStatus(Wallet::STATUS_DEPLETED);
        }

        return $wallet;
    }
}
