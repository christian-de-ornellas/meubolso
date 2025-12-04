<?php

namespace App\Observers;

use App\Models\FixedIncome;
use Illuminate\Support\Carbon;

class FixedIncomeObserver
{
    /**
     * Handle the FixedIncome "saving" event.
     */
    public function saving(FixedIncome $fixedIncome): void
    {
        if ($fixedIncome->start_date && $fixedIncome->months_valid) {
            $startDate = Carbon::parse($fixedIncome->start_date);
            $fixedIncome->end_date = $startDate->copy()->addMonths($fixedIncome->months_valid);
        }
    }
}
