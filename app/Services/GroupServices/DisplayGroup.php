<?php
namespace App\Services\GroupServices;

use App\Http\Resources\GroupResource;
use App\Repositories\GroupRepository;
use App\Models\User;

class DisplayGroup
{
    protected $groupRepository;
    
    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }


    public function indexGroups()
    {
        $group = $this->groupRepository->getAll();
        return GroupResource::collection($group);

    }


    public function usersNotInGroup($groupId)
{
    $usersNotInGroup = User::whereDoesntHave('userGroup', function ($query) use ($groupId) {
        $query->where('userGroup.id', $groupId);
    })->get();

    return response()->json($usersNotInGroup);
}
}