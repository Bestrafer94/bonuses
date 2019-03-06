<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use League\Pipeline\PipelineInterface;

interface WalletUpdatingPipelineFactoryInterface
{
    /**
     * @param User $user
     * @param int  $betValue
     *
     * @return PipelineInterface
     */
    public function create(User $user, int $betValue): PipelineInterface;
}
