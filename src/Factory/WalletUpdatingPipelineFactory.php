<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use App\Pipeline\WalletUpdating\MoneyConversion;
use App\Pipeline\WalletUpdating\MultiplierUpdate;
use App\Pipeline\WalletUpdating\StatusUpdate;
use App\Repository\WalletRepositoryInterface;
use League\Pipeline\Pipeline;
use League\Pipeline\PipelineInterface;

class WalletUpdatingPipelineFactory implements WalletUpdatingPipelineFactoryInterface
{
    /**
     * @var WalletRepositoryInterface
     */
    private $walletRepository;

    /**
     * @param WalletRepositoryInterface $walletRepository
     */
    public function __construct(WalletRepositoryInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function create(User $user, int $betValue): PipelineInterface
    {
        return (new Pipeline())
            ->pipe(new MultiplierUpdate($betValue))
            ->pipe(new StatusUpdate())
            ->pipe(new MoneyConversion($this->walletRepository, $user));
    }
}
