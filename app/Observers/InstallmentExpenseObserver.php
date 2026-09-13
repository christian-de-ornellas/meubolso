<?php

namespace App\Observers;

use App\Models\InstallmentExpense;
use App\Models\Installment;
use Illuminate\Support\Facades\Auth;

class InstallmentExpenseObserver
{
    public function created(InstallmentExpense $expense): void
    {
        for ($i = 1; $i <= $expense->installment_count; $i++) {
            Installment::create([
                'user_id' => $expense->user_id ?? Auth::id(),
                'installment_expense_id' => $expense->id,
                'installment_number' => $i,
                'amount' => $expense->installment_amount,
                'due_date' => $expense->start_date->copy()->addMonths($i - 1),
                'paid' => false,
            ]);
        }
    }
}
