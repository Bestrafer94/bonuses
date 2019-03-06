<?php

declare(strict_types=1);

namespace App\Subscriber;

use App\Entity\Bonus;
use App\Entity\User;
use App\Entity\Wallet;
use App\Event\DepositBonusAssignEvent;
use App\Events;
use App\Factory\BonusFactoryInterface;
use App\Factory\WalletFactoryInterface;
use App\Repository\WalletRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class BonusAssignSubscriber implements EventSubscriberInterface
{
    /**
     * @var WalletFactoryInterface
     */
    private $walletFactory;

    /**
     * @var BonusFactoryInterface
     */
    private $bonusFactory;

    /**
     * @var WalletRepositoryInterface
     */
    private $walletRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param WalletFactoryInterface    $walletFactory
     * @param BonusFactoryInterface     $bonusFactory
     * @param WalletRepositoryInterface $walletRepository
     * @param EntityManagerInterface    $entityManager
     */
    public function __construct(
        WalletFactoryInterface $walletFactory,
        BonusFactoryInterface $bonusFactory,
        WalletRepositoryInterface $walletRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->walletFactory = $walletFactory;
        $this->bonusFactory = $bonusFactory;
        $this->walletRepository = $walletRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::BONUS_ASSIGN_DEPOSIT => 'onDeposit',
            SecurityEvents::INTERACTIVE_LOGIN => 'onLogin',
        ];
    }

    /**
     * @param DepositBonusAssignEvent $depositBonusAssignEvent
     */
    public function onDeposit(DepositBonusAssignEvent $depositBonusAssignEvent)
    {
        $user = $depositBonusAssignEvent->getUser();
        $depositValue = $depositBonusAssignEvent->getDepositValue();

        if ($depositValue > $this->calculateThreshold($user)) {
            $this->handleBonus($user, $this->bonusFactory->createDepositBonus($depositValue));
        }
    }

    /**
     * @param InteractiveLoginEvent $interactiveLoginEvent
     */
    public function onLogin(InteractiveLoginEvent $interactiveLoginEvent)
    {
        /** @var User $user */
        $user = $interactiveLoginEvent->getAuthenticationToken()->getUser();

        /** @var Wallet $bonusMoneyWallet */
        foreach ($this->walletRepository->findActiveBonusMoneyWalletsByUser($user) as $bonusMoneyWallet) {
            if (Bonus::LOGIN_TRIGGER === $bonusMoneyWallet->getBonus()->getEventTrigger()) {
                return;
            }
        }

        $bonus = $this->bonusFactory->createLoginBonus();
        $this->handleBonus($user, $bonus);
    }

    /**
     * @param User  $user
     * @param Bonus $bonus
     */
    private function handleBonus(User $user, Bonus $bonus)
    {
        $wallet = $this->walletFactory->createBonusMoneyWallet($bonus);
        $wallet->setUser($user);
        $this->entityManager->persist($wallet);
        $this->entityManager->flush();
    }

    /**
     * @param User $user
     *
     * @return int
     */
    private function calculateThreshold(User $user): int
    {
        $wallets = $this->walletRepository->findActiveBonusMoneyWalletsByUser($user);

        $threshold = 0;
        /** @var Wallet $wallet */
        foreach ($wallets as $wallet) {
            $threshold += $wallet->getInitialValue() - $wallet->getCurrentValue();
        }

        return $threshold;
    }
}
