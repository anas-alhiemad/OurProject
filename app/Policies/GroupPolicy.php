<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Group;


class GroupPolicy
{
    // /**
    //  * Determine whether the user can view any models.
    //  */
    // public function viewAny(Admin $admin): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can view the model.
    //  */
    // public function view(Admin $admin, Group $group): bool
    // {
    //     //
    // }

    public function create(User $user , Group $group): bool
    {
        if (auth('user')->check()) {
            return $user->id === $group->created_by;
        }

       return false;
    }

    public function update(User $user, Group $group): bool
    {
        if (auth('user')->check()) {
            return $user->id === $group->created_by;
        }

       return false;
    }

    public function delete(User $user, Group $group): bool
    {
        if (auth('user')->check()) {
            return $user->id === $group->created_by;
        }

       return false;
    }

    
    public function cancel(User $user , Group $group): bool
    {
        if (auth('user')->check()) {
            return $user->id === $group->created_by;
        }

       return false;
    }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete(Admin $admin, Group $group): bool
    // {
    //     //
    // }
}
