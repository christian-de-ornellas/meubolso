<?php

namespace App\Models;

use App\Traits\BelongsToAuthUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use BelongsToAuthUser, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'color',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fixedExpenses(): MorphToMany
    {
        return $this->morphedByMany(FixedExpense::class, 'taggable');
    }

    public function variableExpenses(): MorphToMany
    {
        return $this->morphedByMany(VariableExpense::class, 'taggable');
    }

    public function fixedIncomes(): MorphToMany
    {
        return $this->morphedByMany(FixedIncome::class, 'taggable');
    }

    public function variableIncomes(): MorphToMany
    {
        return $this->morphedByMany(VariableIncome::class, 'taggable');
    }
}
