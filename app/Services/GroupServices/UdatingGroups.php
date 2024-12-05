<?php
namespace App\Services\GroupServices;

use App\Models\User;
use App\Models\Group;


class UdatingGroups
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


    public function updateGroup($data,$id)
    {
        $group = $this->model->whereId($id)->first();

        $user = User::whereId(auth()->guard('user')->id())->first(); 
    
        $owner = $this->isOwner($user,$group); 
        if ($owner){
            $group->update($data->validated());
             
            return response()->json(["message" => "Group has been Updated successfuly "],200);}
         
        return response()->json(['Message' => 'You do not have the authority to edit the group.'], 422);
            

        }
            }