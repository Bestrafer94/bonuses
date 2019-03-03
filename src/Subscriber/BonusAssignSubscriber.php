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
    }

    /**
     * @param InteractiveLoginEvent $interactiveLoginEvent
     */
    public function onLogin(InteractiveLoginEvent $interactiveLoginEvent)
    {
        /** @var User $user */
        $user = $interactiveLoginEvent->getAuthenticationToken()->getUser();

        /** @var BonusMoneyWallet $bonusMoneyWallet */
        foreach ($user->getBonusMoneyWallets() as $bonusMoneyWallet) {
            if (Bonus::LOGIN_TRIGGER === $bonusMoneyWallet->getBonus()->getEventTrigger()) {
                return;
            }
        }

        $bonus = $this->bonusFactory->createLoginBonus();
        $wallet = $this->walletFactory->createBonusMoneyWallet($bonus);
        $user->addBonusMoneyWallet($wallet);
        $this->entityManager->persist($wallet);
        $this->entityManager->flush();
    }
}
