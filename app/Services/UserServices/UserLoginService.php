<?php

namespace App\Services\UserServices;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserLoginService 
{
   
    protected $userRepository;
    
    public function __construct(UserRepository  $userRepository)
    {
        $this->userRepository = $userRepository;
    }
   
    function validation ($request)
    {
        $validator = Validator::make($request->all(),$request->rules());
         if ($validator->fails()){
            return response()->json($validator->errors(), 422);}

        return $validator;
    }

    function IsValidData($data)
    {
        if (! $token = auth()->guard('user')->attempt($data->validated()))
        {
            return response()->json(['error' => 'InValidData'], 401);
        }
        return $token;
    }


    
    function GetStatus($email)
    {
        $status = $this->userRepository->GetUserStatus($email);
        return $status;
    }

    function IsVerified($email)
    {
        $verified = $this->userRepository->getVerify($email);
        return $verified;
    }



    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->guard('user')->user(),
        ]);
    }



    public function Login($request)
    {
        $userdata = $this->validation($request);
        $usertoken = $this->IsValidData($userdata);
        if ($usertoken instanceof JsonResponse && $usertoken->getStatusCode() === 401)
        {
            return response()->json(['email' => 'The selected email is invalid.'], 401);
        }
        if($this ->IsVerified($request->email) == null) 
        {
            return response()->json(["Message" => "your account not verified"],422);
        }
        if($this->GetStatus($request->email) == 0)
        {
            return response()->json(["Message" => "your account pending"],422);
        }
        $accessToken = $this->createNewToken($usertoken);
        $user = auth()->guard('user') ;
        return response()->json(["Message" => "successfuly","AccessToken"=>$accessToken->original,"User"=>$user],200);
    }

}