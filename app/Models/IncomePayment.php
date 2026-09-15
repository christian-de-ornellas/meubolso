<?php

namespace App\Models;

use App\Traits\BelongsToAuthUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class IncomePayment extends Model
{
    use BelongsToAuthUser;

    protected $fillable = [
        'user_id',
        'fixed_income_id',
        'variable_income_id',
        'month',
        'year',
        'payment_date',
        'received',
        'dismissed',
        'notes',
    ];

    protected $casts = [
        'month' => 'integer',
        'year' => 'integer',
        'payment_date' => 'date',
        'received' => 'boolean',
        'dismissed' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fixedIncome(): BelongsTo
    {
        return $this->belongsTo(FixedIncome::class);
    }

    public function variableIncome(): BelongsTo
    {
        return $this->belongsTo(VariableIncome::class);
    }

    public function getIncomeAttribute()
    {
        return $this->fixedIncome ?? $this->variableIncome;
    }

    public function getIncomeTypeAttribute(): string
    {
        return $this->fixed_income_id ? 'Fixa' : 'Variável';
    }

    public function scopeByMonth(Builder $query, int $month, int $year): Builder
    {
        return $query->where('month', $month)
            ->where('year', $year);
    }

    public function scopeReceived(Builder $query): Builder
    {
        return $query->where('received', true);
    }

    public function scopeUnreceived(Builder $query): Builder
    {
        return $query->where('received', false);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('dismissed', false);
    }

    public function scopeCurrentMonth(Builder $query): Builder
    {
        $now = now();

        return $query->byMonth($now->month, $now->year);
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

    public static function createForFixedIncome(FixedIncome $income, int $month, int $year): IncomePayment
    {
        return static::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'fixed_income_id' => $income->id,
                'month' => $month,
                'year' => $year,
            ],
            [
                'received' => false,
            ]
        );
    }

    public static function createForVariableIncome(VariableIncome $income, int $month, int $year): IncomePayment
    {
        return static::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'variable_income_id' => $income->id,
                'month' => $month,
                'year' => $year,
            ],
            [
                'received' => false,
            ]
        );
    }
}
