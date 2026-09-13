<?php

namespace App\Models;

use App\Enums\AccountType;
use App\Traits\BelongsToAuthUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use BelongsToAuthUser, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'bank_name',
        'initial_balance',
        'current_balance',
        'color',
        'icon',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'initial_balance' => 'decimal:2',
            'current_balance' => 'decimal:2',
            'status' => 'boolean',
            'type' => AccountType::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fixedExpenses(): HasMany
    {
        return $this->hasMany(FixedExpense::class);
    }

    public function variableExpenses(): HasMany
    {
        return $this->hasMany(VariableExpense::class);
    }

    public function fixedIncomes(): HasMany
    {
        return $this->hasMany(FixedIncome::class);
    }

    public function variableIncomes(): HasMany
    {
        return $this->hasMany(VariableIncome::class);
    }

    public function outgoingTransfers(): HasMany
    {
        return $this->hasMany(AccountTransfer::class, 'from_account_id');
    }

    public function incomingTransfers(): HasMany
    {
        return $this->hasMany(AccountTransfer::class, 'to_account_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }
}
