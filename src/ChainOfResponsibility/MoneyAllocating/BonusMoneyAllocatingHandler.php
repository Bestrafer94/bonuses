<?php

namespace App\ChainOfResponsibility\MoneyAllocating;

use App\Entity\Wallet;
use App\Entity\User;

class BonusMoneyAllocatingHandler extends MoneyAllocatingHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(User $user, int $depositValue)
    {
        $wallets = $this->walletRepository->findBonusMoneyWalletsByUser($user);
        shuffle($wallets);

        /** @var Wallet $wallet */
        foreach ($wallets as $wallet) {
            $shortage = $wallet->getInitialValue() - $wallet->getCurrentValue();
            if ($this->isReadyToAllocateMoney($wallet, $shortage)) {
                if ($shortage <= $depositValue) {
                    $wallet->setCurrentValue($wallet->getInitialValue());
                    $depositValue -= $shortage;
                } else {
                    $wallet->addMoney($depositValue);
                    $depositValue = 0;
                }
                $this->entityManager->persist($wallet);
            }
        }

        if (0 !== $depositValue) {
            parent::handle($user, $depositValue);
        } else {
            $this->entityManager->flush();
        }
    }

    /**
     * @param Wallet $wallet
     * @param int    $shortage
     *
     * @return bool
     */
    private function isReadyToAllocateMoney(Wallet $wallet, int $shortage): bool
    {
        if (Wallet::STATUS_DEPLETED === $wallet->getStatus()) {
            return false;
        }

        if ($shortage <= 0) {
            return false;
        }

        return true;
    }
}
