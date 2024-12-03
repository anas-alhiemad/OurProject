<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DisplayController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json(["Message"=>"get all usere in system","InfoUsers"=>$users]);
    }
}
