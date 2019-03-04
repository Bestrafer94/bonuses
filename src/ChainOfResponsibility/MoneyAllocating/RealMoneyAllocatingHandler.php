<?php

namespace App\ChainOfResponsibility\MoneyAllocating;

use App\Entity\User;
use App\Repository\WalletRepository;
use Doctrine\ORM\EntityManagerInterface;

class RealMoneyAllocatingHandler extends MoneyAllocatingHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var WalletRepository
     */
    private $walletRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param WalletRepository       $walletRepository
     */
    public function __construct(EntityManagerInterface $entityManager, WalletRepository $walletRepository)
    {
        $this->entityManager = $entityManager;
        $this->walletRepository = $walletRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(User $user, int $depositValue)
    {
        $wallet = $this->walletRepository->findOneBy(['user' => $user, 'isOrigin' => true]);
        $wallet->addMoney($depositValue);

        $this->entityManager->persist($wallet);
        $this->entityManager->flush();

        if (0 !== $depositValue) {
            parent::handle($user, $depositValue);
        }
    }
}
