<?php

declare(strict_types=1);

namespace App;

final class Events
{
    const MONEY_ALLOCATE = 'app.money.allocate';
    const MONEY_TAKE = 'app.money.take';

    const BONUS_ASSIGN_DEPOSIT = 'app.bonus.assign.deposit';

    const BET_FINISHED = 'app.bet.finished';
}
