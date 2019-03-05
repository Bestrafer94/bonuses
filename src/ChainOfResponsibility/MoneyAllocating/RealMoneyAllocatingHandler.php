<?php

declare(strict_types=1);

namespace App\ChainOfResponsibility\MoneyAllocating;

use App\Entity\User;

class RealMoneyAllocatingHandler extends MoneyAllocatingHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(User $user, int $depositValue)
    {
        $wallet = $this->walletRepository->findRealMoneyWalletByUser($user);
        $wallet->addMoney($depositValue);

        $this->entityManager->persist($wallet);
        $this->entityManager->flush();

        if (0 !== $depositValue) {
            parent::handle($user, $depositValue);
        }
    }
}
