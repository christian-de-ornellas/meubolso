<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToAuthUser
{
    public static function bootBelongsToAuthUser(): void
    {
        static::addGlobalScope('user', function (Builder $query) {
            if (Auth::check()) {
                $query->where('user_id', Auth::id());
            }
        });

        static::creating(function ($model) {
            if (Auth::check() && ! $model->user_id) {
                $model->user_id = Auth::id();
            }
        });
    }
}
