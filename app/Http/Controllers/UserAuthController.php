<?php

namespace App\Http\Controllers;

use App\Services\UserServices\UserLoginService;
use App\Services\UserServices\UserRegsiterService;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Validator;

class UserAuthController extends Controller
{
    
    protected $userRegisterService;
    protected $userLoginService;

    public function __construct(UserRegsiterService $userRegisterService,UserLoginService $userLoginService)
    {
        $this->userRegisterService = $userRegisterService;
        $this->userLoginService = $userLoginService;
    }

    public function login(LoginRequest $request)
    {

    //    throw new Exception('there are exce');
        return $this->userLoginService->Login($request);
    }



    public function verify($token)
    {

        return $this->userRegisterService->verifyAccount($token);
        // return response()->json(["Message" => "your account has been verified "], 200);
    }


    public function register(UserRegisterRequest $request)
    {
        return $this->userRegisterService->register($request);
    }


    public function logout()
    {
        auth()->guard('user')->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

}
