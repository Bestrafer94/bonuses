<?php

namespace App\ChainOfResponsibility\MoneyTaking;

use App\Entity\User;
use App\Entity\Wallet;

class BonusMoneyTakingHandler extends MoneyTakingHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(User $user, int $betValue)
    {
        $wallets = $this->walletRepository->findBy(
            [
                'user' => $user,
                'isOrigin' => false,
                'status' => Wallet::STATUS_ACTIVE,
            ]
        );
        shuffle($wallets);

        /** @var Wallet $wallet */
        foreach ($wallets as $wallet) {
            $balance = $wallet->getCurrentValue();
            $multiplier = $wallet->getBonus()->getMultiplier();
            $initValue = $wallet->getInitialValue();

            if ($balance > $betValue) {
                $wallet->takeMoney($betValue);
                $wallet->getBonus()->setMultiplier($multiplier - round($betValue / $initValue));
                $betValue = 0;
            } else {
                $wallet->setCurrentValue(0);
                $wallet->setStatus(Wallet::STATUS_WAGERED);
                $betValue -= $balance;
                $wallet->getBonus()->setMultiplier($multiplier - round($balance / $initValue));
            }

            $this->entityManager->persist($wallet);

            if (0 === $betValue) {
                break;
            }
        }

        if (0 !== $betValue) {
            return parent::handle($user, $betValue);
        } else {
            $this->entityManager->flush();
        }
    }
}
