<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use App\Model\Response\BalanceResponseModel;

interface BalanceResponseModelFactoryInterface
{
    /**
     * @return BalanceResponseModel
     */
    public function create(User $user): BalanceResponseModel;
}
