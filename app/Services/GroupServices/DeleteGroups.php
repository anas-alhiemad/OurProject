<?php
namespace App\Services\GroupServices;

use App\Models\Group;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Type\Exception;

class DeleteGroups 
{
 
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


        public function deleteGroup($id)
        {
            $group = $this->model->whereId($id)->first();
            DB::beginTransaction();

            try {
                $owner = $this->isOwner($id);
                if ($owner) {
                $group->delete(); 
                DB::commit();
                return response()->json([
                    "message" => "Group has been deleted successfuly "
                ],200);}
                else{
                    return response()->json(['Message' => 'You do not have the authority to delete the group.'], 422);
                }

            } catch (Exception $e) {
                DB::rollBack();
                throw new Exception("Error deleting Group: " . $e->getMessage());
            }    

}
}