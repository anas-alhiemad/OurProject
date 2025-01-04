<?php

namespace App\Services\GroupServices;
use Exception;
use Validator;
use App\Models\Group;
use App\Models\UserGroup;
use Illuminate\Support\Facades\DB;
use App\Repositories\GroupRepository;
use App\Repositories\GroupUserRepository;

class CreatingGroups{

    protected $groupRepository;
    protected $groupUserRepository;
    
    public function __construct(GroupRepository $groupRepository,GroupUserRepository $groupUserRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->groupUserRepository = $groupUserRepository;
    }


    function relation($groupId)
    {
        $userId = auth()->guard('user')->id();
        $userGroupInfo =['groupId' =>$groupId,'userId'=>$userId,'isOwner'=>true];
        $this->groupUserRepository->create($userGroupInfo);
    }

    function create($request)
    {
            $groupInfo = array_merge($request->all(),
            ['created_by' => auth()->guard('user')->id()]);
            $groupCreated =$this->groupRepository->create($groupInfo);
            $this->relation($groupCreated->id);
          //  $this->sendNotification();
            return response()->json([
                "message" => "Group has been created successfuly ",
                "group" => $groupCreated],200);

    }
 }

