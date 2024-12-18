<?php
namespace App\Services\GroupServices;

use App\Models\User;
use App\Models\Group;
use App\Repositories\GroupRepository;


class DeleteGroups 
{
 
    protected $groupRepository;
    
    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
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
           
            $user = User::whereId(auth()->guard('user')->id())->first(); 
           
            $owner = $this->isOwner($user,$group); 
           
            if ($owner) {
                $group = $this->groupRepository->delete($groupId);
                return response()->json(["message" => "Group has been deleted successfuly "],200);}


            return response()->json(['Message' => 'You do not have the authority to delete the group.'], 422);
        }

}