<?php

namespace App\Subscriber;

use App\Entity\Bonus;
use App\Entity\BonusMoneyWallet;
use App\Entity\User;
use App\Event\DepositBonusAssignEvent;
use App\Events;
use App\Factory\BonusFactoryInterface;
use App\Factory\WalletFactoryInterface;
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
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param WalletFactoryInterface $walletFactory
     * @param BonusFactoryInterface  $bonusFactory
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        WalletFactoryInterface $walletFactory,
        BonusFactoryInterface $bonusFactory,
        EntityManagerInterface $entityManager
    ) {
        $this->walletFactory = $walletFactory;
        $this->bonusFactory = $bonusFactory;
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

        $wallets = $this->entityManager->getRepository(BonusMoneyWallet::class)->findBy(['user' => $user]);

        // @TODO implement rule and verify requirements
        $threshold = 0;
        /** @var BonusMoneyWallet $wallet */
        foreach ($wallets as $wallet) {
            if (BonusMoneyWallet::STATUS_DEPLETED !== $wallet->getStatus()) {
                $threshold += $wallet->getInitialValue() - $wallet->getCurrentValue();
            }
        }

        if ($depositValue > $threshold) {
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

        $wallets = $this->entityManager->getRepository(BonusMoneyWallet::class)->findBy(['user' => $user]);
        /** @var BonusMoneyWallet $bonusMoneyWallet */
        foreach ($wallets as $bonusMoneyWallet) {
            if (Bonus::LOGIN_TRIGGER === $bonusMoneyWallet->getBonus()->getEventTrigger()) {
                return;
            }
        }

        $bonus = $this->bonusFactory->createLoginBonus();
        $wallet = $this->walletFactory->createBonusMoneyWallet($bonus);
        $wallet->setUser($user);
        $this->entityManager->persist($wallet);
        $this->entityManager->flush();
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
}
