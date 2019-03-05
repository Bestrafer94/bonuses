<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Entity\Wallet;

interface WalletRepositoryInterface
{
    /**
     * @param User $user
     *
     * @return Wallet|null
     */
    public function findRealMoneyWalletByUser(User $user): ?Wallet;

    /**
     * @param User $user
     *
     * @return array
     */
    public function findBonusMoneyWalletsByUser(User $user): array;

    /**
     * @param User $user
     *
     * @return array
     */
    public function findActiveBonusMoneyWalletsByUser(User $user): array;
}
