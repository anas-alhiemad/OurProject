<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use App\Services\UserServices\UserDisplayService;

class DisplayController extends Controller
{
    protected $userDisplayService;

    public function __construct(UserDisplayService $userDisplayService)
    {
        $this->userDisplayService = $userDisplayService;
    }

    public function index()
    {
       return $this->userDisplayService->getAllUser();
    }

    public function SearchUser($query)
    {
        return $this->userDisplayService->SearchUser($query);
    }
  

}
