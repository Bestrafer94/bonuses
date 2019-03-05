<?php

declare(strict_types=1);

namespace App\Model;

class UserProfileModel implements UserProfileModerInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var int
     */
    protected $age;

    /**
     * @var string
     */
    protected $gender;

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return UserProfileModel
     */
    public function setName(string $name): UserProfileModel
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return UserProfileModel
     */
    public function setLastName(string $lastName): UserProfileModel
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     *
     * @return UserProfileModel
     */
    public function setAge(int $age): UserProfileModel
    {
        $this->age = $age;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     *
     * @return UserProfileModel
     */
    public function setGender(string $gender): UserProfileModel
    {
        $this->gender = $gender;

        return $this;
    }
}
