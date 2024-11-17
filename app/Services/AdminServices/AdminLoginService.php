<?php

namespace App\Services\AdminServices;

use App\Aspects\LoginAspect;
use Validator;
use App\Models\Admin;
use Jenssegers\Agent\Facades\Agent;

class AdminLoginService
{
    protected $model;
    function __construct()
    {
        $this->model = new Admin;
    }

    function validation($request)
    {

        // $loggingAspect = new LoginAspect(Agent::getFacadeRoot());
        // // $loggingAspect->around(function () use ($request) {
        // //     // ...
        // // });
        // return $loggingAspect->around($request);

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
            // 'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user(),
        ]);
    }

    function Login($request)
    {
        // $loggingAspect = new LoggingAspect(Agent::getFacadeRoot());
        // // $loggingAspect->around(function () use ($request) {
        // //     // ...
        // // });
        // return $loggingAspect->around(function () use ($request) {
        //     // Original createUser method logic
        //     // ...
        //     return ['id' => 1, 'name' => $request['name'], 'email' => $request['email']];
        // });
        $userdata = $this->validation($request);
        $usertoken = $this->IsValidData($userdata);
        $data = $this->createNewToken($usertoken);
        return $data;
    }
}
