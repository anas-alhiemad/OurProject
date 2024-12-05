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

    public function __construct()
    {
        $this->middleware('auth:user', ['except' => ['login', 'register', 'verify']]);
    }


    public function login(LoginRequest $request)
    {

    //    throw new Exception('there are exce');
        return (new UserLoginService())->Login($request);
    }



    public function verify($token)
    {
        $user = User::whereVerification_token($token)->first();
        if (!$user) {
            return response()->json(["Message" => "this token is invalid"], 400);
        }

        $user->verification_token = null;
        $user->email_verified_at = now();
        $user->save();
        return response()->json(["Message" => "your account has been verified "], 200);
    }

    public function register(UserRegisterRequest $request)
    {
        return (new UserRegsiterService())->register($request);
    }


    public function logout()
    {
        auth()->guard('user')->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

}
