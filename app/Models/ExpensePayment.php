<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ExpensePayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'fixed_expense_id',
        'variable_expense_id',
        'month',
        'year',
        'payment_date',
        'paid',
        'notes',
    ];

    protected $casts = [
        'month' => 'integer',
        'year' => 'integer',
        'payment_date' => 'date',
        'paid' => 'boolean',
    ];

    protected static function booted(): void
    {
        // Global scope para filtrar por usuário autenticado
        static::addGlobalScope('user', function (Builder $builder) {
            if (Auth::check()) {
                $builder->where('user_id', Auth::id());
            }
        });

        // Preencher user_id automaticamente ao criar
        static::creating(function (ExpensePayment $payment) {
            if (Auth::check() && ! $payment->user_id) {
                $payment->user_id = Auth::id();
            }
        });
    }

    // Relationships
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

    // Helper para pegar a despesa relacionada (fixa ou variável)
    public function getExpenseAttribute()
    {
        return $this->fixedExpense ?? $this->variableExpense;
    }

    // Helper para pegar o tipo da despesa
    public function getExpenseTypeAttribute(): string
    {
        return $this->fixed_expense_id ? 'Fixa' : 'Variável';
    }

    // Scopes
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

    // Helper methods
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

    /**
     * Find existing payment (including soft-deleted) or restore if deleted
     */
    public static function findOrRestorePayment(int $userId, ?int $fixedExpenseId, ?int $variableExpenseId, int $month, int $year): ?ExpensePayment
    {
        $query = static::withTrashed()
            ->where('user_id', $userId)
            ->where('month', $month)
            ->where('year', $year);

        if ($fixedExpenseId) {
            $query->where('fixed_expense_id', $fixedExpenseId);
        } elseif ($variableExpenseId) {
            $query->where('variable_expense_id', $variableExpenseId);
        }

        $existingPayment = $query->first();

        if ($existingPayment && $existingPayment->trashed()) {
            // Restore the soft-deleted record and reset payment status
            $existingPayment->restore();
            $existingPayment->update([
                'paid' => false,
                'payment_date' => null,
                'notes' => null,
            ]);
        }

        return $existingPayment;
    }

    /**
     * Create or restore payment for a fixed expense
     *
     * @return array [payment, wasRestored]
     */
    public static function createOrRestoreForFixedExpense(FixedExpense $expense, int $month, int $year): array
    {
        $userId = Auth::id();

        $existingPayment = static::findOrRestorePayment($userId, $expense->id, null, $month, $year);

        if ($existingPayment) {
            // Check if it was just restored (trashed before the call)
            return [$existingPayment, $existingPayment->updated_at->isToday()];
        }

        $newPayment = static::create([
            'user_id' => $userId,
            'fixed_expense_id' => $expense->id,
            'month' => $month,
            'year' => $year,
            'paid' => false,
        ]);

        return [$newPayment, false];
    }

    /**
     * Create or restore payment for a variable expense
     *
     * @return array [payment, wasRestored]
     */
    public static function createOrRestoreForVariableExpense(VariableExpense $expense, int $month, int $year): array
    {
        $userId = Auth::id();

        $existingPayment = static::findOrRestorePayment($userId, null, $expense->id, $month, $year);

        if ($existingPayment) {
            // Check if it was just restored (trashed before the call)
            return [$existingPayment, $existingPayment->updated_at->isToday()];
        }

        $newPayment = static::create([
            'user_id' => $userId,
            'variable_expense_id' => $expense->id,
            'month' => $month,
            'year' => $year,
            'paid' => false,
        ]);

        return [$newPayment, false];
    }
}
