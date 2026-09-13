<?php

namespace App\Policies;

use App\Models\AccountTransfer;
use App\Models\User;

class AccountTransferPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, AccountTransfer $accountTransfer): bool
    {
        return $user->id === $accountTransfer->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, AccountTransfer $accountTransfer): bool
    {
        return $user->id === $accountTransfer->user_id;
    }

    public function delete(User $user, AccountTransfer $accountTransfer): bool
    {
        return $user->id === $accountTransfer->user_id;
    }

    public function restore(User $user, AccountTransfer $accountTransfer): bool
    {
        return $user->id === $accountTransfer->user_id;
    }

    public function forceDelete(User $user, AccountTransfer $accountTransfer): bool
    {
        return $user->id === $accountTransfer->user_id;
    }
}
