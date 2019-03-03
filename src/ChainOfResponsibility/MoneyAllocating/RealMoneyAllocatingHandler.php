<?php

namespace App\ChainOfResponsibility\MoneyAllocating;

use App\Entity\User;
use App\Repository\RealMoneyWalletRepository;
use Doctrine\ORM\EntityManagerInterface;

class RealMoneyAllocatingHandler extends MoneyAllocatingHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var RealMoneyWalletRepository
     */
    private $realMoneyWalletRepository;

    /**
     * @param EntityManagerInterface    $entityManager
     * @param RealMoneyWalletRepository $realMoneyWalletRepository
     */
    public function __construct(EntityManagerInterface $entityManager, RealMoneyWalletRepository $realMoneyWalletRepository)
    {
        $this->entityManager = $entityManager;
        $this->realMoneyWalletRepository = $realMoneyWalletRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(User $user, int $depositValue): int
    {
        $wallet = $this->realMoneyWalletRepository->findOneBy(['user' => $user]);
        $wallet->addDepositMoney($depositValue);

        $this->entityManager->persist($wallet);
        $this->entityManager->flush();

        if (0 !== $depositValue) {
            return parent::handle($user, $depositValue);
        }

        return 0;
    }
}
