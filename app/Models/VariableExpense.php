<?php

namespace App\Models;

use App\Traits\BelongsToAuthUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VariableExpense extends Model
{
    use BelongsToAuthUser, Concerns\HasTags, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'account_id',
        'credit_card_id',
        'description',
        'amount',
        'expense_date',
        'notes',
        'attachment',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'expense_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function creditCard(): BelongsTo
    {
        return $this->belongsTo(CreditCard::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(ExpensePayment::class);
    }

    public function scopeByMonth(Builder $query, int $month, int $year): Builder
    {
        return $query->whereYear('expense_date', $year)
            ->whereMonth('expense_date', $month);
    }

    public function scopeRecent(Builder $query, int $limit = 10): Builder
    {
        return $query->orderBy('expense_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($limit);
    }
}
