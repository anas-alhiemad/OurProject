<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Http\Request;

class DisplayController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json(["Message"=>"get all usere in system","InfoUsers"=>$users]);
    }

    public function showUser($groupId)
    {
        $users = UserGroup::get()->with('user');
        return response()->json(["Message"=>"get all usere in group","InfoUsers"=>$users]);
    }
  
    // public function showUser($groupId)
    // {
    //     $users = UserGroup::get()->with('user');
    //     return response()->json(["Message"=>"get all usere in group","InfoUsers"=>$users]);
    // }
}
