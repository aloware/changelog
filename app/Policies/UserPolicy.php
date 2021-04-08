<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function store(User $user): bool
    {
        return true;
    }

    public function delete(User $user, User $deletedUser): bool
    {
        return $user->company_id === $deletedUser->company_id && $user->id !== $deletedUser->id;
    }

    public function update(User $user, User $updatedUser): bool
    {
        return $user->company_id === $updatedUser->company_id;
    }
}
