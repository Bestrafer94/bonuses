<?php

namespace App\ChainOfResponsibility\MoneyTaking;

use App\Entity\RealMoneyWallet;
use App\Entity\User;
use App\Repository\RealMoneyWalletRepository;

class RealMoneyTakingHandler extends MoneyTakingHandler
{
    /**
     * @var RealMoneyWalletRepository
     */
    private $realMoneyWalletRepository;

    /**
     * @param RealMoneyWalletRepository $realMoneyWalletRepository
     */
    public function __construct(RealMoneyWalletRepository $realMoneyWalletRepository)
    {
        $this->realMoneyWalletRepository = $realMoneyWalletRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(User $user, int $betValue): int
    {
        /** @var RealMoneyWallet $wallet */
        $wallet = $this->realMoneyWalletRepository->findOneBy(['user' => $user]);
        $balance = $wallet->getCurrentValue();

        if ($betValue <= $wallet->getCurrentValue()) {
            $wallet->addDepositMoney($betValue * -1);
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
