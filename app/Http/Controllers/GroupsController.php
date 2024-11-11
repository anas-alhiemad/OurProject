<?php

namespace App\Http\Controllers;
use App\Http\Requests\ConstructionGroupRequest;
use App\Services\GroupServices\CreatingGroups;
use Illuminate\Http\Request;
use App\Models\Group;
class GroupsController extends Controller
{
    public function createGroup(ConstructionGroupRequest $request)
    {
        return (new CreatingGroups())->create($request);
    }
}
