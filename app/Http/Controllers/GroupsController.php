<?php

namespace App\Http\Controllers;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Resources\GroupResource;
use App\Services\GroupServices\UdatingGroups;
use App\Services\GroupServices\CreatingGroups;
use App\Http\Requests\Group\UpdatingGroupRequest;
use App\Http\Requests\Group\ConstructionGroupRequest;

class GroupsController extends Controller
{

    public function showGroup()
    {
        $group = Group::all();
         return GroupResource::collection($group);
    }

    public function createGroup(ConstructionGroupRequest $request)
    {
        return (new CreatingGroups())->create($request);
    }
    

    public function updateGroup(UpdatingGroupRequest $request,$id)
    {
        return (new UdatingGroups())->updateGroup($request,$id);
    }
}
