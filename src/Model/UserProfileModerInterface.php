<?php

namespace App\Model;

interface UserProfileModerInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getLastName(): string;

    /**
     * @return int
     */
    public function getAge(): int;

    /**
     * @return string
     */
    public function getGender(): string;
}
