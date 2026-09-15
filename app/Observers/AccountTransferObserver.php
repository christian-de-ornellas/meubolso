<?php

namespace App\Observers;

use App\Models\Account;
use App\Models\AccountTransfer;

class AccountTransferObserver
{
    public function created(AccountTransfer $transfer): void
    {
        $transfer->fromAccount()->decrement('current_balance', $transfer->amount);
        $transfer->toAccount()->increment('current_balance', $transfer->amount);
    }

    public function updating(AccountTransfer $transfer): void
    {
        $originalAmount = $transfer->getOriginal('amount');
        $originalFromAccountId = $transfer->getOriginal('from_account_id');
        $originalToAccountId = $transfer->getOriginal('to_account_id');

        // Revert the old transfer
        Account::where('id', $originalFromAccountId)->increment('current_balance', $originalAmount);
        Account::where('id', $originalToAccountId)->decrement('current_balance', $originalAmount);
    }

    public function updated(AccountTransfer $transfer): void
    {
        // Apply the new transfer
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
