<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Admin;
use App\Models\Group;
use App\Models\Invitation;
use Illuminate\Auth\Access\Response;

class InvitationPolicy
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
    // public function view(Admin $admin, Invitation $invitation): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can create models.
    //  */
    public function create(User $user , Group $group): bool
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
    //  * Determine whether the user can update the model.
    //  */
    // public function update(Admin $admin, Invitation $invitation): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can delete the model.
    //  */
    // public function delete(Admin $admin, Invitation $invitation): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can restore the model.
    //  */
    // public function restore(Admin $admin, Invitation $invitation): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete(Admin $admin, Invitation $invitation): bool
    // {
    //     //
    // }
}
