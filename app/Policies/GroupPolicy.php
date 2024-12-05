<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Group;


class GroupPolicy
{

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

}
