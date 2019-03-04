<?php

namespace App\Subscriber;

use App\Entity\BonusMoneyWallet;
use App\Entity\RealMoneyWallet;
use App\Event\BetFinishedEvent;
use App\Events;
use App\Repository\RealMoneyWalletRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BetFinishedSubscriber implements EventSubscriberInterface
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
    public static function getSubscribedEvents()
    {
        return [
            Events::BET_FINISHED => 'onBetFinished',
        ];
    }

    /**
     * @param BetFinishedEvent $betFinishedEvent
     */
    public function onBetFinished(BetFinishedEvent $betFinishedEvent)
    {
        $user = $betFinishedEvent->getUser();

        $wallets = $user->getBonusMoneyWallets();

        /** @var BonusMoneyWallet $wallet */
        foreach ($wallets as $wallet) {
            if (BonusMoneyWallet::STATUS_WAGERED === $wallet->getStatus() && 0 === $wallet->getCurrentValue()) {
                $wallet->setStatus(BonusMoneyWallet::STATUS_DEPLETED);
            } elseif (BonusMoneyWallet::STATUS_WAGERED === $wallet->getStatus() && 0 === $wallet->getCurrentValue()) {
                $wallet->setStatus(BonusMoneyWallet::STATUS_ACTIVE);
            }

            if ($wallet->getBonus()->getMultiplier() <= 0) {
                /** @var RealMoneyWallet $realMoneyWallet */
                $realMoneyWallet = $this->realMoneyWalletRepository->findOneBy(['user' => $user]);
                $realMoneyWallet->addDepositMoney($wallet->getInitialValue());
                $wallet->setStatus(BonusMoneyWallet::STATUS_DEPLETED);
            }
        }
    }
}
