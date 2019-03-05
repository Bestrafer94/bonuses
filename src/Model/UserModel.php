<?php

declare(strict_types=1);

namespace App\Model;

class UserModel implements UserModelInterface
{
    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * {@inheritdoc}
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return UserModel
     */
    public function setUsername(string $username): UserModel
    {
        $this->username = $username;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return UserModel
     */
    public function setPassword(string $password): UserModel
    {
        $this->password = $password;

        return $this;
    }
}
