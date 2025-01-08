<?php

namespace App\Services\GroupServices;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Http\Resources\GroupResource;
use App\Repositories\GroupRepository;

class DisplayGroup
{
    protected $groupRepository;
    protected $userRepository;

    public function __construct(GroupRepository $groupRepository, UserRepository $userRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->userRepository = $userRepository;
    }


    public function indexGroups()
    {
        $group = $this->groupRepository->getAll();
        return response()->json([
            "message" => "all Groups ",
            "groups" => $group
        ]);
    }

    public function usersInGroup($groupId)
    {
        $usersInGroup = $this->groupRepository->usersInGroup($groupId);

        return response()->json(["usersInGroup" => $usersInGroup->original]);
    }

    public function filesGroup($group)
    {
        $files = $group->files;
        return $files;
    }

    public function usersNotInGroup($groupId)
    {
        $usersNotInGroup = $this->userRepository->usersNotInGroup($groupId);
        return response()->json(["usersNotInGroup" => $usersNotInGroup]);
    }
}
