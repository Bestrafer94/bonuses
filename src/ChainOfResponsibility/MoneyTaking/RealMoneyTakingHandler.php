<?php

namespace App\ChainOfResponsibility\MoneyTaking;

use App\Entity\User;
use App\Entity\Wallet;

class RealMoneyTakingHandler extends MoneyTakingHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(User $user, int $betValue)
    {
        /** @var Wallet $wallet */
        $wallet = $this->walletRepository->findRealMoneyWalletByUser($user);

        $balance = $wallet->getCurrentValue();

        if ($betValue <= $wallet->getCurrentValue()) {
            $wallet->takeMoney($betValue);
            $betValue = 0;
        } else {
            $wallet->setCurrentValue(0);
            $betValue -= $balance;
        }

        $this->entityManager->persist($wallet);

        if (0 !== $betValue) {
            return parent::handle($user, $betValue);
        } else {
            $this->entityManager->flush();
        }
    }
}
