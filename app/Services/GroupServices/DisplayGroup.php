<?php

namespace App\Services\GroupServices;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Http\Resources\GroupResource;
use App\Repositories\GroupRepository;
use App\Repositories\GroupUserRepository;

class DisplayGroup
{
    protected $groupRepository;
    protected $userRepository;

    protected $groupUserRepository;

    public function __construct(GroupRepository $groupRepository,UserRepository $userRepository,GroupUserRepository $groupUserRepository)

    {
        $this->groupRepository = $groupRepository;
        $this->userRepository = $userRepository;
        $this->groupUserRepository = $groupUserRepository;
    }


    public function indexGroups()
    {
        $group = $this->groupUserRepository->getAll();
        return response()->json([
            "message" => "all Groups ",
            "groups" => $group
        ]);
    }


    public function showMyGroups()
    {
        $myGroup = $this->groupUserRepository->getMyGroups();

            return $myGroup;
    }

    public function usersInGroup($groupId)
    {
        $usersInGroup = $this->groupRepository->usersInGroup($groupId);
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
