<?php

namespace App\ChainOfResponsibility\MoneyAllocating;

use App\Entity\BonusMoneyWallet;
use App\Entity\User;
use App\Repository\BonusMoneyWalletRepository;

class BonusMoneyAllocatingHandler extends MoneyAllocatingHandler
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
    public function handle(User $user, int $depositValue): int
    {
        $wallets = $this->bonusMoneyWalletRepository->findBy(['user' => $user]);

        /** @var BonusMoneyWallet $bonusMoneyWallet */
        foreach ($wallets as $bonusMoneyWallet) {
            if (BonusMoneyWallet::STATUS_DEPLETED !== $bonusMoneyWallet->getStatus()) {
                $shortAge = $bonusMoneyWallet->getInitialValue() - $bonusMoneyWallet->getCurrentValue();
                if ($shortAge <= $depositValue && $shortAge > 0) {
                    dump($shortAge, 'elo1');die;
                    $bonusMoneyWallet->addDepositMoney($depositValue);
                    $depositValue -= $shortAge;
                } elseif ($shortAge > $depositValue) {
                    $bonusMoneyWallet->addDepositMoney($depositValue);

                    return 0;
                }
            }
        }

        if (0 !== $depositValue) {
            return parent::handle($user, $depositValue);
        }
    }
}
