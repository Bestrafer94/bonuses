<?php

declare(strict_types=1);

namespace App\ChainOfResponsibility\MoneyTaking;

use App\Entity\User;
use App\Entity\Wallet;
use App\Exception\NotEnoughMoneyException;

class BonusMoneyTakingHandler extends MoneyTakingHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(User $user, int $betValue)
    {
        $wallets = $this->walletRepository->findActiveBonusMoneyWalletsByUser($user);
        shuffle($wallets);

        /** @var Wallet $wallet */
        foreach ($wallets as $wallet) {
            $balance = $wallet->getCurrentValue();

            if ($balance > $betValue) {
                $wallet->takeMoney($betValue);
                $betValue = 0;
            } else {
                $wallet->setCurrentValue(0);
                $wallet->setStatus(Wallet::STATUS_WAGERED);
                $betValue -= $balance;
            }

            $this->entityManager->persist($wallet);

            if (0 === $betValue) {
                break;
            }
        }

        if (0 < $betValue) {
            throw new NotEnoughMoneyException();
        } else {
            $this->entityManager->flush();
        }
    }
}
