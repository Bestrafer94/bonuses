<?php

namespace App\Handler;

use App\Factory\BalanceResponseModelFactoryInterface;
use App\Handler\Command\BalanceCommand;
use App\Model\Response\BalanceResponseModel;

class BalanceCommandHandler
{
    /**
     * @var BalanceResponseModelFactoryInterface
     */
    private $balanceResponseModelFactory;

    /**
     * @param BalanceResponseModelFactoryInterface $balanceResponseModelFactory
     */
    public function __construct(BalanceResponseModelFactoryInterface $balanceResponseModelFactory)
    {
        $this->balanceResponseModelFactory = $balanceResponseModelFactory;
    }

    /**
     * @param BalanceCommand $command
     *
     * @return BalanceResponseModel
     */
    public function handle(BalanceCommand $command): BalanceResponseModel
    {
        return $this->balanceResponseModelFactory->create($command->getUser());
    }
}
