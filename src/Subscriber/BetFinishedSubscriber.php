<?php

namespace App\Subscriber;

use App\Entity\Wallet;
use App\Event\BetFinishedEvent;
use App\Events;
use App\Repository\WalletRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BetFinishedSubscriber implements EventSubscriberInterface
{
    /**
     * @var WalletRepositoryInterface
     */
    private $walletRepository;

    /**
     * @param WalletRepositoryInterface $walletRepository
     */
    public function __construct(WalletRepositoryInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
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

        $wallets = $this->walletRepository->findBonusMoneyWalletsByUser($user);

        /** @var Wallet $wallet */
        foreach ($wallets as $wallet) {
            if (Wallet::STATUS_WAGERED === $wallet->getStatus() && 0 === $wallet->getCurrentValue()) {
                $wallet->setStatus(Wallet::STATUS_DEPLETED);
            } elseif (Wallet::STATUS_WAGERED === $wallet->getStatus() && 0 !== $wallet->getCurrentValue()) {
                $wallet->setStatus(Wallet::STATUS_ACTIVE);
            }

            if ($wallet->getBonus()->getMultiplier() <= 0) {
                /** @var Wallet $realMoneyWallet */
                $realMoneyWallet = $this->walletRepository->findActiveBonusMoneyWalletsByUser($user);
                $realMoneyWallet->addMoney($wallet->getInitialValue());
                $wallet->setStatus(Wallet::STATUS_DEPLETED);
            }
        }
    }
}
