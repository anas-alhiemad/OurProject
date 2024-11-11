<?php

namespace App\Http\Controllers;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Services\GroupServices\UdatingGroups;
use App\Services\GroupServices\CreatingGroups;
use App\Http\Requests\ConstructionGroupRequest;

class GroupsController extends Controller
{
    public function createGroup(ConstructionGroupRequest $request)
    {
        return (new CreatingGroups())->create($request);
    }

    public function updateGroup(ConstructionGroupRequest $request,$id)
    {
        return (new UdatingGroups())->updateGroup($request,$id);
    }
}
