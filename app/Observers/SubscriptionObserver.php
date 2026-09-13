<?php

namespace App\Observers;

use App\Enums\BillingCycle;
use App\Models\Subscription;

class SubscriptionObserver
{
    public function saving(Subscription $subscription): void
    {
        if ($subscription->start_date && $subscription->billing_cycle) {
            $startDate = $subscription->start_date;
            $now = now();

            $nextDate = $startDate->copy();

            while ($nextDate->lte($now)) {
                $nextDate = match ($subscription->billing_cycle) {
                    BillingCycle::Weekly => $nextDate->addWeek(),
                    BillingCycle::Monthly => $nextDate->addMonth(),
                    BillingCycle::Yearly => $nextDate->addYear(),
                    default => $nextDate->addMonth(),
                };
            }

            $subscription->next_billing_date = $nextDate;
        }
    }
}
