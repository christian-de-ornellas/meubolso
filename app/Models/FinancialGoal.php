<?php

namespace App\Models;

use App\Traits\BelongsToAuthUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialGoal extends Model
{
    use BelongsToAuthUser, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'target_amount',
        'current_amount',
        'deadline',
        'color',
        'icon',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'target_amount' => 'decimal:2',
            'current_amount' => 'decimal:2',
            'deadline' => 'date',
            'status' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->whereColumn('current_amount', '>=', 'target_amount');
    }

    public function getProgressPercentageAttribute(): float
    {
        if ($this->target_amount <= 0) {
            return 0;
        }

        return round(($this->current_amount / $this->target_amount) * 100, 1);
    }

    public function getRemainingAmountAttribute(): float
    {
        return (float) max(0, $this->target_amount - $this->current_amount);
    }
}
