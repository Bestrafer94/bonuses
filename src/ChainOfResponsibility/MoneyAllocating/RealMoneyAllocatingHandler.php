<?php

namespace App\ChainOfResponsibility\MoneyAllocating;

use App\Entity\User;

class RealMoneyAllocatingHandler extends MoneyAllocatingHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(User $user, int $depositValue)
    {
        $wallet = $this->walletRepository->findOneBy(['user' => $user, 'isOrigin' => true]);
        $wallet->addMoney($depositValue);

        $this->entityManager->persist($wallet);
        $this->entityManager->flush();

        if (0 !== $depositValue) {
            parent::handle($user, $depositValue);
        }
    }
}
