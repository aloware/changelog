<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
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

    public function store(User $user, Category $category): bool
    {
        return $user->company->id == $category->company_id;
    }

    public function update(User $user, Category $category): bool
    {
        return $user->company->id == $category->company_id;
    }
}
