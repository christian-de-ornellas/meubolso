<?php

namespace App\Models;

use App\Traits\BelongsToAuthUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Budget extends Model
{
    use BelongsToAuthUser, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'month',
        'year',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'month' => 'integer',
            'year' => 'integer',
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

    public function scopeByMonth(Builder $query, int $month, int $year): Builder
    {
        return $query->where('month', $month)->where('year', $year);
    }

    public function scopeCurrentMonth(Builder $query): Builder
    {
        return $query->byMonth(now()->month, now()->year);
    }

    public function getSpentAttribute(): float
    {
        $fixedExpenses = FixedExpense::where('category_id', $this->category_id)
            ->active()
            ->sum('amount');

        $variableExpenses = VariableExpense::where('category_id', $this->category_id)
            ->byMonth($this->month, $this->year)
            ->sum('amount');

        return (float) ($fixedExpenses + $variableExpenses);
    }

    public function getPercentageUsedAttribute(): float
    {
        if ($this->amount <= 0) {
            return 0;
        }

        return round(($this->spent / $this->amount) * 100, 1);
    }

    public function getRemainingAttribute(): float
    {
        return (float) max(0, $this->amount - $this->spent);
    }
}
