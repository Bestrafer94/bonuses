<?php

declare(strict_types=1);

namespace App\Subscriber;

use App\Entity\Wallet;
use App\Event\BetFinishedEvent;
use App\Events;
use App\Repository\WalletRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BetFinishedSubscriber implements EventSubscriberInterface
{
    /**
     * @var WalletRepositoryInterface
     */
    private $walletRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param WalletRepositoryInterface $walletRepository
     * @param EntityManagerInterface    $entityManager
     */
    public function __construct(WalletRepositoryInterface $walletRepository, EntityManagerInterface $entityManager)
    {
        $this->walletRepository = $walletRepository;
        $this->entityManager = $entityManager;
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
        $betValue = $betFinishedEvent->getBetValue();

        $wallets = $this->walletRepository->findBonusMoneyWalletsByUser($user);

        /** @var Wallet $wallet */
        foreach ($wallets as $wallet) {
            $bonus = $wallet->getBonus();
            $bonus->setMultiplier(
                $this->calculateMultiplierValue($bonus->getMultiplier(), $betValue, $wallet->getInitialValue())
            );

            if (Wallet::STATUS_WAGERED === $wallet->getStatus() && 0 === $wallet->getCurrentValue()) {
                $wallet->setStatus(Wallet::STATUS_DEPLETED);
            } elseif (Wallet::STATUS_WAGERED === $wallet->getStatus() && 0 !== $wallet->getCurrentValue()) {
                $wallet->setStatus(Wallet::STATUS_ACTIVE);
            }

            if ($wallet->getBonus()->getMultiplier() <= 0) {
                /** @var Wallet $realMoneyWallet */
                $realMoneyWallet = $this->walletRepository->findRealMoneyWalletByUser($user);
                $realMoneyWallet->addMoney($wallet->getInitialValue());
                $wallet->setStatus(Wallet::STATUS_DEPLETED);
            }

            $this->entityManager->persist($wallet);
        }

        $this->entityManager->flush();
    }

    /**
     * @param int $oldMultiplier
     * @param int $betValue
     * @param int $initialValue
     *
     * @return int
     */
    private function calculateMultiplierValue(int $oldMultiplier, int $betValue, int $initialValue): int
    {
        return (int) ($oldMultiplier - round($betValue / $initialValue));
    }
}
