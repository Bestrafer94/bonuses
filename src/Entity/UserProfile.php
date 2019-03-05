<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserProfileRepository")
 */
class UserProfile
{
    const MALE_GENDER = 'male';
    const FEMALE_GENDER = 'female';
    const UNSPECIFIED_GENDER = 'unspecified';

    const GENDERS = [
        self::MALE_GENDER,
        self::FEMALE_GENDER,
        self::UNSPECIFIED_GENDER,
    ];

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
     * @ORM\Column(type="string", length=100)
     *
     * @var string
     */
    private $lastName;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @var string
     */
    private $gender;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @var User
     */
    private $user;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return UserProfile
     */
    public function setName(string $name): UserProfile
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return UserProfile
     */
    public function setLastName(string $lastName): UserProfile
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     *
     * @return UserProfile
     */
    public function setAge(int $age): UserProfile
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     *
     * @return UserProfile
     */
    public function setGender(string $gender): UserProfile
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return UserProfile
     */
    public function setUser(User $user): UserProfile
    {
        $this->user = $user;

        return $this;
    }
}
