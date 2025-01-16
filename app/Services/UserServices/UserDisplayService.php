<?php
namespace App\Services\UserServices;

use App\Repositories\UserRepository;


class UserDisplayService 
{
    protected $userRepository;
    
    public function __construct(UserRepository  $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUser()
    {
        $users = $this->userRepository->getAll();
        return response()->json([
            "message" => "all Users ",
            "Users In System" => $users]);
    }


    public function SearchUser($query)
    {
        $users = $this->userRepository->getUserSearch($query);
        return response()->json([
            "message" => "the User ",
            "User" => $users]);
    }
  
   
}