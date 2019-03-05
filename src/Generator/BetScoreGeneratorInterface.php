<?php

declare(strict_types=1);

namespace App\Generator;

interface BetScoreGeneratorInterface
{
    /**
     * @param int $betValue
     *
     * @return int
     */
    public function generate(int $betValue): int;
}
