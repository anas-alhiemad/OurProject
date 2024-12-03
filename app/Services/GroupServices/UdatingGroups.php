<?php
namespace App\Services\GroupServices;

use App\Models\Group;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Type\Exception;

class UdatingGroups{
        protected $model;
        function __construct(){
                $this -> model = new Group();
            }


        public function isOwner($id){
            $group = $this->model->whereId($id)->first();
            $userId = auth()->guard('user')->id();

            if ($group->created_by == $userId) { return true ;} 
                                          else {return false;}
                
            }


            
        public function updateGroup($data,$id)
        {
            $group = $this->model->whereId($id)->first();
            DB::beginTransaction();


            $user = User::whereId(auth()->guard('user')->id())->first(); 
            
            $owner = $this->isOwner($user,$group); 
            if ($owner) {
                $group->update($data->validated()); 
                return response()->json(["message" => "Group has been Updated successfuly "],200);}
                
            return response()->json(['Message' => 'You do not have the authority to edit the group.'], 422);
                


        }}