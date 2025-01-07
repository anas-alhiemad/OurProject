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

    public function showTracing()
    {
        $logFilePath = storage_path('logs/logger.log');
        if (!file_exists($logFilePath)) {
            return response()->json(['error' => 'Log file not found.'], 404);
        }
        $logs = file_get_contents($logFilePath);

        return response($logs, 200)->header('Content-Type', 'text/plain');
    }


}
