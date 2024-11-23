<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class AdminController extends Controller
{

    public function showUserPending(){
        $UsersPending = User::whereStatus(0)
                             ->where('verification_token', null)
                             ->get();
        return response()->json(["Users" => UserResource::collection($UsersPending)]);
    }
    

    public function changeStatus($userId){
        $user = User::whereId($userId)->first();
            if (!$user){
                return response()->json(["Message" => "this Id is invalid"], 400);
                 }
        $user->status = true;
        $user->save();
        return response()->json(['message' => 'User successfully change status']);

    }
}
