<?php

namespace tests\Factory;

use App\Generator\BetScoreGenerator;
use App\Generator\BetScoreGeneratorInterface;
use PHPUnit\Framework\TestCase;

class BetScoreGeneratorTest extends TestCase
{
    /**
     * @var BetScoreGeneratorInterface
     */
    private $betScoreGenerator;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->betScoreGenerator = new BetScoreGenerator();
    }

    /**
     * @dataProvider betValueProvider
     *
     * @param int $betValue
     */
    public function testGenerate(int $betValue)
    {
        $score = $this->betScoreGenerator->generate($betValue);
        $this->assertInternalType('int', $score);
        $this->assertThat(
            $score,
            $this->logicalAnd(
                $this->greaterThanOrEqual(0),
                $this->lessThanOrEqual(BetScoreGenerator::WIN_SPIN_COURSE * $betValue)
            )
        );
    }

    /**
     * @return array
     */
    public function betValueProvider(): array
    {
        return [
            [100],
            [87],
            [481],
            [200],
        ];
    }
}
