<?php
namespace App\Services\GroupServices;

use App\Models\User;
use App\Models\Group;
use App\Repositories\UserRepository;
use App\Repositories\GroupRepository;


class DeleteGroups 
{

    protected $groupRepository;
    protected $userRepository;

    public function __construct(GroupRepository $groupRepository,UserRepository $userRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->userRepository = $userRepository;
    }


    public function isOwner($user,$group)
    { 
        if ($user->can('update', $group)) 
                    return true;
        return false;            
    }


        public function deleteGroup($groupId)
        {
            $group = $this->groupRepository->getById($groupId);
           
            $user =  $this->userRepository->getById(auth()->guard('user')->id()); 
           
            $owner = $this->isOwner($user,$group); 
           
            if ($owner) {
                $group = $this->groupRepository->delete($groupId);
                return response()->json(["message" => "Group has been deleted successfuly "],200);}


            return response()->json(['Message' => 'You do not have the authority to delete the group.'], 422);
        }

}