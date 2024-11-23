<?php

namespace App\Services\AdminServices;

use App\Models\Admin;
use App\Aspects\LoginAspect;
use App\Aspects\LoggingAspect;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AdminLoginService
{
    protected $model;
    function __construct()
    {
        $this->model = new Admin;
    }

    function validation($request)
    {

        $validator = Validator::make($request->all(),$request->rules());
        if ($validator->fails()){
            return response()->json($validator->errors(), 422);}
        return $validator;
    }


    function IsValidData($data)
    {
        if (!$token = auth()->guard('admin')->attempt($data->validated())) {
            return response()->json(['error' => 'InValidData'], 422);
        }

        return $token;
    }



    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'user' => auth()->user(),
        ]);
    }

    function Login($request)
    {
        
        $userdata = $this->validation($request);
        $usertoken = $this->IsValidData($userdata);
        if ($usertoken instanceof JsonResponse && $usertoken->getStatusCode() === 422) {
            return response()->json(['email' => 'The selected email is invalid.'], 401);
        }
        $data = $this->createNewToken($usertoken);
        return response()->json(["Message" => "User successfully signed in","data" => $data -> original]);
     }
}
