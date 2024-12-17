<?php
namespace App\Services\GroupServices;

use App\Models\User;
use App\Models\Group;


class DeleteGroups 
{
 
    protected $model;
    function __construct(){
            $this -> model = new Group();
        }


        public function isOwner($user,$group)
        { 
            if ($user->can('update', $group)) 
                        return true;
            return false;            
                            }

        public function deleteGroup($id)
        {
            $group = $this->model->whereId($id)->first(); 
           
            $user = User::whereId(auth()->guard('user')->id())->first(); 
           
            $owner = $this->isOwner($user,$group); 
           
            if ($owner) {
                $group->delete();
                return response()->json(["message" => "Group has been deleted successfuly "],200);}


            return response()->json(['Message' => 'You do not have the authority to delete the group.'], 422);
        }

}