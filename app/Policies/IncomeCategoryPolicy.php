<?php

namespace App\Policies;

use App\Models\IncomeCategory;
use App\Models\User;

class IncomeCategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, IncomeCategory $incomeCategory): bool
    {
        return $user->id === $incomeCategory->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, IncomeCategory $incomeCategory): bool
    {
        return $user->id === $incomeCategory->user_id;
    }

    public function delete(User $user, IncomeCategory $incomeCategory): bool
    {
        return $user->id === $incomeCategory->user_id;
    }

    public function restore(User $user, IncomeCategory $incomeCategory): bool
    {
        return $user->id === $incomeCategory->user_id;
    }

    public function forceDelete(User $user, IncomeCategory $incomeCategory): bool
    {
        return $user->id === $incomeCategory->user_id;
    }
}
