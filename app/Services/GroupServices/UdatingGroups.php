<?php
namespace App\Services\GroupServices;

use App\Repositories\UserRepository;


class UdatingGroups
{
    protected $groupRepository;
    protected $userRepository;

    public function __construct(GroupRepository $groupRepository,UserRepository $userRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->userRepository = $userRepository;
    }


        public function isOwner($id){
            $group = $this->model->whereId($id)->first();
            $userId = auth()->guard('user')->id();

            if ($group->created_by == $userId) { return true ;} 
                                          else {return false;}
                
            }



    public function updateGroup($groupId,$data)
    {
      
        $user =  $this->userRepository->getById(auth()->guard('user')->id()); 
        $group = $this->groupRepository->getById($groupId);
        $owner = $this->isOwner($user,$group); 
        
        if ($owner){   
            $group = $this->groupRepository->update($groupId,$data->all());
            return response()->json(["message" => "Group has been Updated successfuly "],200);}
         

        return response()->json(['Message' => 'You do not have the authority to edit the group.'], 422);
            

    }




}
