<?php

namespace App\ChainOfResponsibility\MoneyTaking;

use App\Entity\BonusMoneyWallet;
use App\Entity\User;
use App\Repository\BonusMoneyWalletRepository;

class BonusMoneyTakingHandler extends MoneyTakingHandler
{
    /**
     * @var BonusMoneyWalletRepository
     */
    private $bonusMoneyWalletRepository;

    /**
     * @param BonusMoneyWalletRepository $bonusMoneyWalletRepository
     */
    public function __construct(BonusMoneyWalletRepository $bonusMoneyWalletRepository)
    {
        $this->bonusMoneyWalletRepository = $bonusMoneyWalletRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(User $user, int $betValue): int
    {
        $wallets = $this->bonusMoneyWalletRepository->findBy(['user' => $user]);

        /** @var BonusMoneyWallet $wallet */
        foreach ($wallets as $wallet) {
            if (BonusMoneyWallet::STATUS_ACTIVE === $wallet->getStatus()) {
                $balance = $wallet->getCurrentValue();
                $multiplier = $wallet->getBonus()->getMultiplier();
                $initValue = $wallet->getInitialValue();

                if ($balance > $betValue) {
                    $wallet->addDepositMoney($betValue * -1);
                    $wallet->getBonus()->setMultiplier($multiplier - round($betValue / $initValue));
                    $betValue = 0;
                } else {
                    $wallet->setCurrentValue(0);
                    $wallet->setStatus(BonusMoneyWallet::STATUS_WAGERED);
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
