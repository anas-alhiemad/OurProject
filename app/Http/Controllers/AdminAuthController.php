<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\AdminServices\AdminLoginService;

class AdminAuthController extends Controller
{

    public function __construct() {
        $this->middleware('auth:admin', ['except' => ['login']]);
    }




    public function login(LoginRequest $request){
    	return (new AdminLoginService())->Login($request);
    }

    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }





















    // public function refresh() {
    //     return $this->createNewToken(auth()->refresh());
    // }



    // public function userProfile() {

    //     $user=User::where('id',Auth::id())->get();
    //     return response()->json($user);
    // }





    // protected function createNewToken($token){
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => auth()->factory()->getTTL() * 60,
    //         'user' => auth()->user()
    //     ]);
    // }

}
