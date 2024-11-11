<?php

namespace App\Services\GroupServices;
use Illuminate\Support\Facades\DB;
use App\Models\Group;
use Validator;
class CreatingGroups{

    protected $model;
    function __construct(){
        $this -> model = new Group();
    }

    function create($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $data['created_by'] = auth()->guard('user')->id();
            $group = Group::create($data);
          //  $this->sendNotification();
            DB::commit();
            return response()->json([
                "message" => "Group has been created successfuly "
            ],200);
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
 }
    
