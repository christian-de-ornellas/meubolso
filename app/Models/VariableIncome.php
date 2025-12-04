<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class VariableIncome extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'income_category_id',
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
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Global scope to filter by authenticated user
     */
    protected static function booted(): void
    {
        static::addGlobalScope('user', function (Builder $query) {
            if (Auth::check()) {
                $query->where('user_id', Auth::id());
            }
        });

        static::creating(function (VariableIncome $income) {
            if (Auth::check() && !$income->user_id) {
                $income->user_id = Auth::id();
            }
        });
    }

    /**
     * Relationships
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function incomeCategory(): BelongsTo
    {
        return $this->belongsTo(IncomeCategory::class);
    }

    /**
     * Scopes
     */
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
