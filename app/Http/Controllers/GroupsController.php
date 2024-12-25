<?php

namespace App\Http\Controllers;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Resources\GroupResource;
use App\Services\GroupServices\DeleteGroups;
use App\Services\GroupServices\UdatingGroups;
use App\Services\GroupServices\CreatingGroups;
use App\Http\Requests\Group\UpdatingGroupRequest;
use App\Http\Requests\Group\ConstructionGroupRequest;
use App\Services\GroupServices\DisplayGroup;

class GroupsController extends Controller
{

    protected $createGroupService;
    protected $updateGroupService;
    protected $deletedGroupService;
    protected $displayGroupService;

    public function __construct(CreatingGroups $createGroupService,UdatingGroups $updateGroupService,DeleteGroups $deletedGroupService,DisplayGroup $displayGroupService)
    {
        $this->createGroupService = $createGroupService;
        $this->updateGroupService = $updateGroupService;
        $this->deletedGroupService = $deletedGroupService;
        $this->displayGroupService = $displayGroupService;

    }

    public function showGroup()
    {
        $groups = $this->displayGroupService->indexGroups();
         return  $groups;
    }

    public function usersNotInGroup($groupId)
    {
        $users= $this->displayGroupService->usersNotInGroup($groupId);
         return  $users;
    }

    

    public function usersInGroup($groupId)
    {
        $users= $this->displayGroupService->usersInGroup($groupId);
         return  $users;
    }

    
    public function createGroup(ConstructionGroupRequest $request)
    {
        return $this->createGroupService->create($request);
    }
    

    public function updateGroup(UpdatingGroupRequest $request,$groupId)
    {
        return $this->updateGroupService->updateGroup($groupId,$request);
    }

    public function deleteGroup($groupId)
    {
        return  $this->deletedGroupService->deleteGroup($groupId);
    }
}
