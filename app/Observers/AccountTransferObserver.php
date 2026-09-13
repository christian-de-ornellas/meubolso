<?php

namespace App\Observers;

use App\Models\AccountTransfer;

class AccountTransferObserver
{
    public function created(AccountTransfer $transfer): void
    {
        $transfer->fromAccount()->decrement('current_balance', $transfer->amount);
        $transfer->toAccount()->increment('current_balance', $transfer->amount);
    }

    public function deleted(AccountTransfer $transfer): void
    {
        $transfer->fromAccount()->increment('current_balance', $transfer->amount);
        $transfer->toAccount()->decrement('current_balance', $transfer->amount);
    }

    public function restored(AccountTransfer $transfer): void
    {
        $transfer->fromAccount()->decrement('current_balance', $transfer->amount);
        $transfer->toAccount()->increment('current_balance', $transfer->amount);
    }
}
