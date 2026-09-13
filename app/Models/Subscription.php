<?php

namespace App\Models;

use App\Enums\BillingCycle;
use App\Traits\BelongsToAuthUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use BelongsToAuthUser, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'account_id',
        'name',
        'description',
        'amount',
        'billing_cycle',
        'start_date',
        'next_billing_date',
        'status',
        'color',
        'icon',
        'url',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'billing_cycle' => BillingCycle::class,
            'start_date' => 'date',
            'next_billing_date' => 'date',
            'status' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    public function scopeUpcomingBilling(Builder $query, int $days = 7): Builder
    {
        return $query->active()
            ->whereNotNull('next_billing_date')
            ->where('next_billing_date', '<=', now()->addDays($days))
            ->where('next_billing_date', '>=', now());
    }

    public function getMonthlyEquivalentAttribute(): float
    {
        return match ($this->billing_cycle) {
            BillingCycle::Monthly => (float) $this->amount,
            BillingCycle::Yearly => round((float) $this->amount / 12, 2),
            BillingCycle::Weekly => round((float) $this->amount * 4.33, 2),
            default => (float) $this->amount,
        };
    }
}
