<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserProfileRepository")
 */
class UserProfile
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
}