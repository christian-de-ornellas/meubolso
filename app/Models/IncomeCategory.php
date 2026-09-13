<?php

namespace App\Models;

use App\Traits\BelongsToAuthUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomeCategory extends Model
{
    use BelongsToAuthUser, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'color',
        'icon',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fixedIncomes(): HasMany
    {
        return $this->hasMany(FixedIncome::class);
    }

    public function variableIncomes(): HasMany
    {
        return $this->hasMany(VariableIncome::class);
    }
}
