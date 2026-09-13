<?php

namespace App\Providers;

use App\Models\AccountTransfer;
use App\Models\FixedExpense;
use App\Models\FixedIncome;
use App\Models\InstallmentExpense;
use App\Models\Subscription;
use App\Observers\AccountTransferObserver;
use App\Observers\FixedExpenseObserver;
use App\Observers\FixedIncomeObserver;
use App\Observers\InstallmentExpenseObserver;
use App\Observers\SubscriptionObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        FixedExpense::observe(FixedExpenseObserver::class);
        FixedIncome::observe(FixedIncomeObserver::class);
        AccountTransfer::observe(AccountTransferObserver::class);
        Subscription::observe(SubscriptionObserver::class);
        InstallmentExpense::observe(InstallmentExpenseObserver::class);
    }
}
