<?php

declare(strict_types=1);

namespace App\Model\Response;

class BalanceResponseModel
{
    /**
     * @var int
     */
    private $total;

    /**
     * @var int
     */
    private $realMoney;

    /**
     * @var int[]
     */
    private $bonuses;

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     *
     * @return BalanceResponseModel
     */
    public function setTotal(int $total): BalanceResponseModel
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return int
     */
    public function getRealMoney(): int
    {
        return $this->realMoney;
    }

    /**
     * @param int $realMoney
     *
     * @return BalanceResponseModel
     */
    public function setRealMoney(int $realMoney): BalanceResponseModel
    {
        $this->realMoney = $realMoney;

        return $this;
    }

    /**
     * @return int[]
     */
    public function getBonuses(): array
    {
        return $this->bonuses;
    }

    /**
     * @param int[] $bonuses
     *
     * @return BalanceResponseModel
     */
    public function setBonuses(array $bonuses): BalanceResponseModel
    {
        $this->bonuses = $bonuses;

        return $this;
    }
}
