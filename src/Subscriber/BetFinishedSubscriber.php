<?php

declare(strict_types=1);

namespace App\Subscriber;

use App\Entity\Wallet;
use App\Event\BetFinishedEvent;
use App\Events;
use App\Pipeline\WalletUpdating\MoneyConversion;
use App\Pipeline\WalletUpdating\MultiplierUpdate;
use App\Pipeline\WalletUpdating\StatusUpdate;
use App\Repository\WalletRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use League\Pipeline\Pipeline;

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
            $pipeLine = (new Pipeline())
                ->pipe(new MultiplierUpdate($betValue))
                ->pipe(new StatusUpdate())
                ->pipe(new MoneyConversion($this->walletRepository, $user));

            $wallet = $pipeLine->process($wallet);

            $this->entityManager->persist($wallet);
        }

        $this->entityManager->flush();
    }
}
