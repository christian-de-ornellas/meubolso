<?php

namespace App\Policies;

use App\Models\ExpensePayment;
use App\Models\User;

class ExpensePaymentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ExpensePayment $expensePayment): bool
    {
        return $user->id === $expensePayment->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, ExpensePayment $expensePayment): bool
    {
        return $user->id === $expensePayment->user_id;
    }

    public function delete(User $user, ExpensePayment $expensePayment): bool
    {
        return $user->id === $expensePayment->user_id;
    }
}
