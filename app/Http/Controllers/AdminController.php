<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Services\AdminServices\AdminFunctionService;

class AdminController extends Controller
{
    protected $adminFunctionService;

    public function __construct(AdminFunctionService $adminFunctionService)
    {
        $this->adminFunctionService = $adminFunctionService;
       
    }
    public function showUserPending(){
        $UsersPending = User::whereStatus(0)
                             ->where('verification_token', null)
                             ->get();
        return response()->json(["Users" => UserResource::collection($UsersPending)]);
    }
    

    public function changeStatus($userId)
    {

        return $this->adminFunctionService->changeStatus($userId);
    }
}
