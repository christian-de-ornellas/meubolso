<?php

namespace App\Models;

use App\Traits\BelongsToAuthUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstallmentExpense extends Model
{
    use BelongsToAuthUser, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'account_id',
        'credit_card_id',
        'description',
        'total_amount',
        'installment_count',
        'installment_amount',
        'start_date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'installment_amount' => 'decimal:2',
            'start_date' => 'date',
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

    public function installments(): HasMany
    {
        return $this->hasMany(Installment::class);
    }

    public function getPaidCountAttribute(): int
    {
        return $this->installments()->where('paid', true)->count();
    }

    public function getRemainingCountAttribute(): int
    {
        return $this->installment_count - $this->paid_count;
    }

    public function getProgressPercentageAttribute(): float
    {
        if ($this->installment_count <= 0) {
            return 0;
        }

        return round(($this->paid_count / $this->installment_count) * 100, 1);
    }
}
