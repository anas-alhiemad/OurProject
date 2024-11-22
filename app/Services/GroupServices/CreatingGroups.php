<?php

namespace App\Services\GroupServices;
use Exception;
use Validator;
use App\Models\Group;
use App\Models\UserGroup;
use Illuminate\Support\Facades\DB;

class CreatingGroups{

    protected $model;
    function __construct(){
        $this -> model = new Group();
    }

    function relation($groupId)
    {
     $userId = auth()->guard('user')->id();
     $userGroup = new UserGroup();
     $userGroup->groupId = $groupId;
     $userGroup->userId = $userId;
     $userGroup->isOwner = true;
     $userGroup->save();
    }

    function create($request)
    {
            $data = $request->validated();
            $data['created_by'] = auth()->guard('user')->id();
            $group = Group::create($data);
            $this->relation($group->id);
          //  $this->sendNotification();
                 return response()->json([
                "message" => "Group has been created successfuly ",
                "group" => $group
            ],200);
     
    }
 }
    
