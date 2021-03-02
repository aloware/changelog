<?php

namespace App\Policies;

use App\Models\Changelog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ChangelogPolicy
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

    public function update(User $user, Changelog $changelog): bool
    {
        return $user->company->id === $changelog->project->company->id;
    }

    public function delete(User $user, Changelog $changelog): bool
    {
        return $user->company->id === $changelog->project->company->id && $changelog->author->id === $user->id;
    }
}
