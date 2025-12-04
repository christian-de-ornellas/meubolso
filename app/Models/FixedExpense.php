<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class FixedExpense extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
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

        static::creating(function (FixedExpense $expense) {
            if (Auth::check() && !$expense->user_id) {
                $expense->user_id = Auth::id();
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scopes
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
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

    /**
     * Check if expense is expiring soon
     */
    public function isExpiringSoon(int $days = 30): bool
    {
        if (!$this->end_date || !$this->status) {
            return false;
        }

        return $this->end_date->isFuture()
            && $this->end_date->diffInDays(Carbon::now()) <= $days;
    }
}
