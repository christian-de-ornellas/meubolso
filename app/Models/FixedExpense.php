<?php

namespace App\Models;

use App\Traits\BelongsToAuthUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FixedExpense extends Model
{
    use BelongsToAuthUser, Concerns\HasTags, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'account_id',
        'credit_card_id',
        'description',
        'amount',
        'start_date',
        'months_valid',
        'end_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
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

    public function creditCard(): BelongsTo
    {
        return $this->belongsTo(CreditCard::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(ExpensePayment::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    public function scopeActiveInMonth(Builder $query, int $month, int $year): Builder
    {
        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end = Carbon::create($year, $month, 1)->endOfMonth();

        return $query->where('status', true)
            ->where('start_date', '<=', $end)
            ->where(fn ($q) => $q->whereNull('end_date')->orWhere('end_date', '>=', $start));
    }

    public function scopeExpiringSoon(Builder $query, int $days = 30): Builder
    {
        $futureDate = Carbon::now()->addDays($days);

        return $query->where('status', true)
            ->whereNotNull('end_date')
            ->where('end_date', '<=', $futureDate)
            ->where('end_date', '>=', Carbon::now());
    }

    public function scopeByMonth(Builder $query, int $month, int $year): Builder
    {
        return $query->whereYear('start_date', $year)
            ->whereMonth('start_date', $month);
    }

    public function isExpiringSoon(int $days = 30): bool
    {
        if (! $this->end_date || ! $this->status) {
            return false;
        }

        return $this->end_date->isFuture()
            && $this->end_date->diffInDays(Carbon::now()) <= $days;
    }
}
