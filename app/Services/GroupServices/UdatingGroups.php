<?php
namespace App\Services\GroupServices;

use App\Models\Group;

use App\Repositories\GroupRepository;


class UdatingGroups{
        protected $model;
        function __construct(){
                $this -> model = new Group();
            }


class UdatingGroups
{
    protected $groupRepository;
    
    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }


        public function isOwner($id){
            $group = $this->model->whereId($id)->first();
            $userId = auth()->guard('user')->id();

            if ($group->created_by == $userId) { return true ;} 
                                          else {return false;}
                
            }



    public function updateGroup($groupId,$data)
    {
      
        $user = User::whereId(auth()->guard('user')->id())->first(); 
        $group = $this->groupRepository->getById($groupId);
        $owner = $this->isOwner($user,$group); 
        
        if ($owner){   
            $group = $this->groupRepository->update($groupId,$data->all());
            return response()->json(["message" => "Group has been Updated successfuly "],200);}
         

        return response()->json(['Message' => 'You do not have the authority to edit the group.'], 422);
            

    }




}
