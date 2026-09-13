<?php

namespace App\Models;

use App\Traits\BelongsToAuthUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Installment extends Model
{
    use BelongsToAuthUser;

    protected $fillable = [
        'user_id',
        'installment_expense_id',
        'installment_number',
        'amount',
        'due_date',
        'paid',
        'payment_date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'due_date' => 'date',
            'paid' => 'boolean',
            'payment_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function installmentExpense(): BelongsTo
    {
        return $this->belongsTo(InstallmentExpense::class);
    }

    public function scopePaid(Builder $query): Builder
    {
        return $query->where('paid', true);
    }

    public function scopeUnpaid(Builder $query): Builder
    {
        return $query->where('paid', false);
    }

    public function scopeOverdue(Builder $query): Builder
    {
        return $query->unpaid()->where('due_date', '<', now());
    }

    public function scopeByMonth(Builder $query, int $month, int $year): Builder
    {
        return $query->whereYear('due_date', $year)
            ->whereMonth('due_date', $month);
    }
}
