<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VariableExpense;
use Illuminate\Auth\Access\Response;

class VariableExpensePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, VariableExpense $variableExpense): bool
    {
        return $user->id === $variableExpense->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, VariableExpense $variableExpense): bool
    {
        return $user->id === $variableExpense->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, VariableExpense $variableExpense): bool
    {
        return $user->id === $variableExpense->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, VariableExpense $variableExpense): bool
    {
        return $user->id === $variableExpense->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, VariableExpense $variableExpense): bool
    {
        return $user->id === $variableExpense->user_id;
    }
}
