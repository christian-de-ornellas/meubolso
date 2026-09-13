<?php

namespace App\Policies;

use App\Models\IncomePayment;
use App\Models\User;

class IncomePaymentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, IncomePayment $incomePayment): bool
    {
        return $user->id === $incomePayment->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, IncomePayment $incomePayment): bool
    {
        return $user->id === $incomePayment->user_id;
    }

    public function delete(User $user, IncomePayment $incomePayment): bool
    {
        return $user->id === $incomePayment->user_id;
    }
}
