<?php

namespace App\ChainOfResponsibility\MoneyTaking;

use App\Entity\User;
use App\Entity\Wallet;
use App\Repository\WalletRepository;

class RealMoneyTakingHandler extends MoneyTakingHandler
{
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
    public function handle(User $user, int $betValue): int
    {
        /** @var Wallet $wallet */
        $wallet = $this->walletRepository->findOneBy(['user' => $user, 'isOrigin' => true]);

        $balance = $wallet->getCurrentValue();

        if ($betValue <= $wallet->getCurrentValue()) {
            $wallet->takeMoney($betValue);
            $betValue -= 0;
        } else {
            $wallet->setCurrentValue(0);
            $betValue -= $balance;
        }

        if (0 !== $betValue) {
            return parent::handle($user, $betValue);
        }
    }
}
