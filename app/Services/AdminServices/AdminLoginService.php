<?php

namespace App\Services\AdminServices;
use Validator;
use App\Models\Admin;
class AdminLoginService 
{
    protected $model;
    function __construct()
    {
        $this->model = new Admin;
    }
 
    function validation ($request){
        $validator = Validator::make($request->all(),$request->rules());
        if ($validator->fails()){
            return response()->json($validator->errors(), 422);}
        return $validator;
    }


    function IsValidData($data)
    {
        if (!$token = auth()->guard('admin')->attempt($data->validated())){
                return response()->json(['error' => 'InValidData'], 422);}

        return $token;
    }

    

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            // 'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user(),
        ]);
    }

    function Login($request)
    {
        $userdata = $this->validation($request);
        $usertoken = $this->IsValidData($userdata);
        $data = $this->createNewToken($usertoken);
        return $data;
    }

}