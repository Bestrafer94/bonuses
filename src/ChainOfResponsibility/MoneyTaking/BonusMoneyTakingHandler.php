<?php

namespace App\ChainOfResponsibility\MoneyTaking;

use App\Entity\User;
use App\Entity\Wallet;
use App\Repository\WalletRepository;

class BonusMoneyTakingHandler extends MoneyTakingHandler
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
        $wallets = $this->walletRepository->findBy(['user' => $user, 'isOrigin' => false]);

        /** @var Wallet $wallet */
        foreach ($wallets as $wallet) {
            if (Wallet::STATUS_ACTIVE === $wallet->getStatus()) {
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
            }
        }

        if (0 !== $betValue) {
            return parent::handle($user, $betValue);
        }

        return $betValue;
    }
}
