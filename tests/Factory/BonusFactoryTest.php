<?php

namespace tests\Factory;

use App\Entity\Bonus;
use App\Factory\BonusFactory;
use App\Factory\BonusFactoryInterface;
use PHPUnit\Framework\TestCase;

class BonusFactoryTest extends TestCase
{
    /**
     * @var BonusFactoryInterface
     */
    private $bonusFactory;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->bonusFactory = new BonusFactory();
    }

    public function testCreateDepositBonus()
    {
        $depositValue = 500;
        $bonus = $this->bonusFactory->createDepositBonus($depositValue);

        $this->assertInstanceOf(Bonus::class, $bonus);
        $this->assertEquals(Bonus::DEPOSIT_BONUS_NAME, $bonus->getName());
        $this->assertEquals(Bonus::DEPOSIT_TRIGGER, $bonus->getEventTrigger());
        $this->assertThat(
            $bonus->getMultiplier(),
            $this->logicalAnd(
                $this->greaterThanOrEqual(BonusFactory::MULTIPLIER_MIN),
                $this->lessThanOrEqual(BonusFactory::MULTIPLIER_MAX)
            )
        );
        $this->assertThat(
            $bonus->getValueOfReward(),
            $this->logicalAnd(
                $this->greaterThan(0),
                $this->lessThanOrEqual($depositValue)
            )
        );
    }

    public function testCreateLoginBonus()
    {
        $bonus = $this->bonusFactory->createLoginBonus();

        $this->assertInstanceOf(Bonus::class, $bonus);
        $this->assertEquals(Bonus::LOGIN_BONUS_NAME, $bonus->getName());
        $this->assertEquals(Bonus::LOGIN_TRIGGER, $bonus->getEventTrigger());
        $this->assertThat(
            $bonus->getMultiplier(),
            $this->logicalAnd(
                $this->greaterThanOrEqual(BonusFactory::MULTIPLIER_MIN),
                $this->lessThanOrEqual(BonusFactory::MULTIPLIER_MAX)
            )
        );
        $this->assertThat(
            $bonus->getValueOfReward(),
            $this->logicalAnd(
                $this->greaterThan(BonusFactory::LOGIN_VALUE_OF_REWARD_MIN),
                $this->lessThanOrEqual(BonusFactory::LOGIN_VALUE_OF_REWARD_MAX)
            )
        );
    }
}
