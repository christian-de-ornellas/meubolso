<?php

namespace App\Observers;

use App\Models\FixedExpense;
use Carbon\Carbon;

class FixedExpenseObserver
{
    /**
     * Handle the FixedExpense "saving" event.
     * Calculate end_date before saving.
     */
    public function saving(FixedExpense $fixedExpense): void
    {
        if ($fixedExpense->start_date && $fixedExpense->months_valid) {
            $startDate = Carbon::parse($fixedExpense->start_date);
            $fixedExpense->end_date = $startDate->copy()->addMonths($fixedExpense->months_valid);
        }
    }
}
