<?php

declare(strict_types=1);

namespace App\Form\Data;

class BetData
{
    /**
     * @var int
     */
    protected $betValue;

    /**
     * @return int
     */
    public function getBetValue(): ?int
    {
        return $this->betValue;
    }

    /**
     * @param int $betValue
     *
     * @return BetData
     */
    public function setBetValue(int $betValue): BetData
    {
        $this->betValue = $betValue;

        return $this;
    }
}
