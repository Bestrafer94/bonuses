<?php

namespace App\Generator;

class BetScoreGenerator implements BetScoreGeneratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function generate(int $betValue): int
    {
        $spins = round($betValue / 10);
        $score = 0;

        for ($i = 0; $i < $spins; ++$i) {
            $score += rand(0, 1) ? 10 : 0;
        }

        return $score;
    }
}
