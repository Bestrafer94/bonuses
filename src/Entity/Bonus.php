<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BonusRepository")
 */
abstract class Bonus
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $multiplier;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $valueOfReward;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Bonus
     */
    public function setId(int $id): Bonus
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Bonus
     */
    public function setName(string $name): Bonus
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getMultiplier(): int
    {
        return $this->multiplier;
    }

    /**
     * @param int $multiplier
     *
     * @return Bonus
     */
    public function setMultiplier(int $multiplier): Bonus
    {
        $this->multiplier = $multiplier;

        return $this;
    }

    /**
     * @return int
     */
    public function getValueOfReward(): int
    {
        return $this->valueOfReward;
    }

    /**
     * @param int $valueOfReward
     *
     * @return Bonus
     */
    public function setValueOfReward(int $valueOfReward): Bonus
    {
        $this->valueOfReward = $valueOfReward;

        return $this;
    }

    /**
     * @return string
     */
    abstract public function getTrigger(): string;
}
