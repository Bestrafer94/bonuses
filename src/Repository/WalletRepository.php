<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Entity\Wallet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class WalletRepository extends ServiceEntityRepository implements WalletRepositoryInterface
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wallet::class);
    }

    /**
     * {@inheritdoc}
     */
    public function findRealMoneyWalletByUser(User $user): ?Wallet
    {
        return $this->findOneBy(['user' => $user, 'isOrigin' => true]);
    }

    /**
     * {@inheritdoc}
     */
    public function findBonusMoneyWalletsByUser(User $user): array
    {
        return $this->findBy(
            [
                'user' => $user,
                'isOrigin' => false,
                'status' => [Wallet::STATUS_ACTIVE, Wallet::STATUS_WAGERED],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function findActiveBonusMoneyWalletsByUser(User $user): array
    {
        return $this->findBy(
            [
                'user' => $user,
                'isOrigin' => false,
                'status' => Wallet::STATUS_ACTIVE,
            ]
        );
    }
}
