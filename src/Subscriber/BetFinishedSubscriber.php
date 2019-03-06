<?php

declare(strict_types=1);

namespace App\Subscriber;

use App\Entity\Wallet;
use App\Event\BetFinishedEvent;
use App\Events;
use App\Factory\WalletUpdatingPipelineFactoryInterface;
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
     * @var WalletUpdatingPipelineFactoryInterface
     */
    private $walletUpdatingPipelineFactory;

    /**
     * @param WalletRepositoryInterface              $walletRepository
     * @param EntityManagerInterface                 $entityManager
     * @param WalletUpdatingPipelineFactoryInterface $walletUpdatingPipelineFactory
     */
    public function __construct(
        WalletRepositoryInterface $walletRepository,
        EntityManagerInterface $entityManager,
        WalletUpdatingPipelineFactoryInterface $walletUpdatingPipelineFactory
    ) {
        $this->walletRepository = $walletRepository;
        $this->entityManager = $entityManager;
        $this->walletUpdatingPipelineFactory = $walletUpdatingPipelineFactory;
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
        $pipeLine = $this->walletUpdatingPipelineFactory->create($user, $betValue);

        /** @var Wallet $wallet */
        foreach ($wallets as $wallet) {
            $wallet = $pipeLine->process($wallet);

            $this->entityManager->persist($wallet);
        }

        $this->entityManager->flush();
    }
}
