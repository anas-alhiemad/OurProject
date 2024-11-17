<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class AdminController extends Controller
{
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
