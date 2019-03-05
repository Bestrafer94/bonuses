<?php

declare(strict_types=1);

namespace App\Form\Data;

class DepositData
{
    /**
     * @var int
     */
    protected $depositValue;

    /**
     * @return int|null
     */
    public function getDepositValue(): ?int
    {
        return $this->depositValue;
    }

    /**
     * @param int $depositValue
     *
     * @return DepositData
     */
    public function setDepositValue(int $depositValue): DepositData
    {
        $this->depositValue = $depositValue;

        return $this;
    }
}
