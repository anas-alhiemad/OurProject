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

    // /**
    //  * Refresh a token.
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function refresh() {
    //     return $this->createNewToken(auth()->refresh());
    // }

    // /**
    //  * Get the authenticated User.
    //  *
    //  *
    //  *
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function userProfile() {

    //     //$user=User::where('id',Auth::id())->get();
    //     return response()->json(auth()->guard('user')->user());
    // }

    // /**
    //  * Get the token array structure.
    //  *
    //  * @param  string $token
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // protected function createNewToken($token){
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => auth()->factory()->getTTL() * 60,
    //         'user' => auth()->guard('user')->user(),
    //     ]);
    // }

}
