<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Admin;
use App\Models\Group;
use App\Models\Invitation;
use Illuminate\Auth\Access\Response;

class InvitationPolicy
{

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

    }
