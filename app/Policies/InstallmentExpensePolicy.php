<?php

namespace App\Policies;

use App\Models\InstallmentExpense;
use App\Models\User;

class InstallmentExpensePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, InstallmentExpense $installmentExpense): bool
    {
        return $user->id === $installmentExpense->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, InstallmentExpense $installmentExpense): bool
    {
        return $user->id === $installmentExpense->user_id;
    }

    public function delete(User $user, InstallmentExpense $installmentExpense): bool
    {
        return $user->id === $installmentExpense->user_id;
    }

    public function restore(User $user, InstallmentExpense $installmentExpense): bool
    {
        return $user->id === $installmentExpense->user_id;
    }

    public function forceDelete(User $user, InstallmentExpense $installmentExpense): bool
    {
        return $user->id === $installmentExpense->user_id;
    }
}
