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
            $worker = $this->model->whereId($id)->first();
                
            }
            
        public function updateGroup($id, $data)
        {
            $group = Group::findOrFail($id);
            
            DB::beginTransaction();

            try {
                $group->update($data);
                DB::commit();
                return $group;
            } catch (Exception $e) {
                DB::rollBack();
                throw new Exception("Error updating Group: " . $e->getMessage());
            }
        }}