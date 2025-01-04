<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Interfaces\RepositoryInterface;
use App\Models\Group;

class GroupRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct(Group $model)
    {
        parent::__construct($model);
    }

    public function usersInGroup($groupId)
    {
        $usersInGroup = Group::with(['userGroup.user'=>function ($query) {
            $query->where('status', 1);}])->find($groupId);
        $users = $usersInGroup->userGroup->map(function ($userGroup) {
            return $userGroup->user;
        });
        return response()->json($users);
    }
}