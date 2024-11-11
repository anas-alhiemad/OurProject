<?php

namespace App\Services\UserServices;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserLoginService 
{
    protected $model;
    function __construct()
    {
        $this->model = new User;
    }
 
    function validation ($request){
        $validator = Validator::make($request->all(),$request->rules());
         if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
         return $validator;
        }
    function IsValidData($data){
        if (! $token = auth()->guard('user')->attempt($data->validated())){
            return response()->json(['error' => 'InValidData'], 401);
        }
        return $token;
    }

    function GetStatus($email){
        $user = $this->model->whereEmail($email)->first();
        $status = $user->status;
        return $status;
    }

    function IsVerified($email){
        $user = $this->model->whereEmail($email)->first();
        $verified = $user->email_verified_at;
        return $verified;
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->guard('user')->user(),
        ]);
    }

    function Login($request){
        $userdata = $this->validation($request);
        $usertoken = $this->IsValidData($userdata);
        if ($usertoken instanceof JsonResponse && $usertoken->getStatusCode() === 401) {
            return response()->json(['email' => 'The selected email is invalid.'], 401);
        }
        if($this ->IsVerified($request->email) == null) {
            return response()->json(["Message" => "your account not verified"],422);
        }elseif($this->GetStatus($request->email) == 0){
            return response()->json(["Message" => "your account pending"],422);
        };
        $accessToken = $this->createNewToken($usertoken);
        $user = auth()->guard('user') ;
        return response()->json(["Message" => "successfuly","AccessToken"=>$accessToken->original,"User"=>$user],200);
    }

}