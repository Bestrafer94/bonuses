<?php

declare(strict_types=1);

namespace App\Generator;

class BetScoreGenerator implements BetScoreGeneratorInterface
{
    const SPIN_COST = 10;
    const WIN_SPIN_COURSE = 2;

    /**
     * {@inheritdoc}
     */
    public function generate(int $betValue): int
    {
        $spins = round($betValue / self::SPIN_COST);
        $score = 0;

        for ($i = 0; $i < $spins; ++$i) {
            $score += rand(0, 1) ? self::SPIN_COST * self::WIN_SPIN_COURSE : 0;
        }

        return $score;
    }
}
