<?php

namespace App\ChainOfResponsibility\MoneyTaking;

use App\Entity\User;
use App\Repository\WalletRepository;
use Doctrine\ORM\EntityManagerInterface;

abstract class MoneyTakingHandler implements MoneyTakingHandlerInterface
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
     * @var MoneyTakingHandlerInterface
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
    public function setNext(MoneyTakingHandlerInterface $moneyTakingHandler): MoneyTakingHandlerInterface
    {
        $this->nextHandler = $moneyTakingHandler;

        return $moneyTakingHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(User $user, int $beValue)
    {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($user, $beValue);
        }
    }
}
