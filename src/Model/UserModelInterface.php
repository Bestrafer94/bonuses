<?php

declare(strict_types=1);

namespace App\Model;

interface UserModelInterface
{
    /**
     * @return string
     */
    public function getUsername(): string;

    /**
     * @return string
     */
    public function getPassword(): string;
}
