<?php

namespace App\Providers;

use App\Models\FixedExpense;
use App\Models\FixedIncome;
use App\Observers\FixedExpenseObserver;
use App\Observers\FixedIncomeObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FixedExpense::observe(FixedExpenseObserver::class);
        FixedIncome::observe(FixedIncomeObserver::class);
    }
}
