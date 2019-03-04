<?php

namespace App\ChainOfResponsibility\MoneyAllocating;

use App\Entity\User;
use App\Repository\WalletRepository;
use Doctrine\ORM\EntityManagerInterface;

abstract class MoneyAllocatingHandler implements MoneyAllocatingHandlerInterface
{
    /**
     * @var WalletRepository
     */
    protected $walletRepository;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var MoneyAllocatingHandlerInterface
     */
    private $nextHandler;

    /**
     * @param WalletRepository       $walletRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(WalletRepository $walletRepository, EntityManagerInterface $entityManager)
    {
        $this->walletRepository = $walletRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function setNext(MoneyAllocatingHandlerInterface $moneyAllocatingHandler): MoneyAllocatingHandlerInterface
    {
        $this->nextHandler = $moneyAllocatingHandler;

        return $moneyAllocatingHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(User $user, int $depositValue)
    {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($user, $depositValue);
        }
    }
}
