<?php
namespace App\Services\AdminServices;

use App\Repositories\UserRepository;

class AdminFunctionService
{

    protected $userRepository;
    
    public function __construct(UserRepository  $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function changeStatus($userId)
    {
        $response =  $this->userRepository->accountStatus($userId);
        return $response;
    }

}