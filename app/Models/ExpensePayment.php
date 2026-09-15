<?php

namespace App\Models;

use App\Traits\BelongsToAuthUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class ExpensePayment extends Model
{
    use BelongsToAuthUser, HasFactory;

    protected $fillable = [
        'user_id',
        'fixed_expense_id',
        'variable_expense_id',
        'installment_id',
        'account_id',
        'month',
        'year',
        'payment_date',
        'paid',
        'dismissed',
        'notes',
        'attachment',
    ];

    protected $casts = [
        'month' => 'integer',
        'year' => 'integer',
        'payment_date' => 'date',
        'paid' => 'boolean',
        'dismissed' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fixedExpense(): BelongsTo
    {
        return $this->belongsTo(FixedExpense::class);
    }

    public function variableExpense(): BelongsTo
    {
        return $this->belongsTo(VariableExpense::class);
    }

    public function installment(): BelongsTo
    {
        return $this->belongsTo(Installment::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function getExpenseAttribute()
    {
        return $this->fixedExpense ?? $this->variableExpense ?? $this->installment?->installmentExpense;
    }

    public function getExpenseTypeAttribute(): string
    {
        if ($this->installment_id) {
            return 'Parcelamento';
        }

        return $this->fixed_expense_id ? 'Fixa' : 'Variável';
    }

    public function scopeByMonth(Builder $query, int $month, int $year): Builder
    {
        return $query->where('month', $month)
            ->where('year', $year);
    }

    public function scopePaid(Builder $query): Builder
    {
        return $query->where('paid', true);
    }

    public function scopeUnpaid(Builder $query): Builder
    {
        return $query->where('paid', false);
    }

    public function scopeCurrentMonth(Builder $query): Builder
    {
        $now = now();

        return $query->byMonth($now->month, $now->year);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('dismissed', false);
    }

    public function getMonthNameAttribute(): string
    {
        $monthNames = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro',
        ];

        return $monthNames[$this->month] ?? '';
    }

    public function getMonthYearAttribute(): string
    {
        return $this->month_name.'/'.$this->year;
    }

    public static function createForFixedExpense(FixedExpense $expense, int $month, int $year): ExpensePayment
    {
        return static::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'fixed_expense_id' => $expense->id,
                'month' => $month,
                'year' => $year,
            ],
            [
                'paid' => false,
            ]
        );
    }

    public static function createForVariableExpense(VariableExpense $expense, int $month, int $year): ExpensePayment
    {
        return static::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'variable_expense_id' => $expense->id,
                'month' => $month,
                'year' => $year,
            ],
            [
                'paid' => false,
            ]
        );
    }

    public static function createForInstallment(Installment $installment, int $month, int $year): ExpensePayment
    {
        return static::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'installment_id' => $installment->id,
                'month' => $month,
                'year' => $year,
            ],
            [
                'paid' => $installment->paid,
            ]
        );
    }
}
