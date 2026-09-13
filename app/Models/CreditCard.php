<?php

namespace App\Models;

use App\Enums\CardBrand;
use App\Traits\BelongsToAuthUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreditCard extends Model
{
    use BelongsToAuthUser, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'last_four_digits',
        'brand',
        'credit_limit',
        'closing_day',
        'due_day',
        'color',
        'icon',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'credit_limit' => 'decimal:2',
            'status' => 'boolean',
            'brand' => CardBrand::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function variableExpenses(): HasMany
    {
        return $this->hasMany(VariableExpense::class);
    }

    public function fixedExpenses(): HasMany
    {
        return $this->hasMany(FixedExpense::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }
}
