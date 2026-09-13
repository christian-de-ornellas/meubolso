<?php

namespace App\Models;

use App\Traits\BelongsToAuthUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VariableIncome extends Model
{
    use BelongsToAuthUser, Concerns\HasTags, SoftDeletes;

    protected $fillable = [
        'user_id',
        'income_category_id',
        'account_id',
        'description',
        'amount',
        'income_date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'income_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function incomeCategory(): BelongsTo
    {
        return $this->belongsTo(IncomeCategory::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function scopeByMonth(Builder $query, int $month, int $year): Builder
    {
        return $query->whereYear('income_date', $year)
            ->whereMonth('income_date', $month);
    }

    public function scopeRecent(Builder $query, int $limit = 10): Builder
    {
        return $query->orderBy('income_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($limit);
    }
}
