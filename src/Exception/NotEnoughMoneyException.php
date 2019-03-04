<?php

namespace App\Exception;

class NotEnoughMoneyException extends \Exception
{
    /**
     * {@inheritdoc}
     */
    public function getMessageKey()
    {
        return 'Not enough money on account!';
    }
}
