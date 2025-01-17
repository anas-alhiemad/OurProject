<?php
namespace App\Services\UserServices;

use App\Repositories\UserRepository;
use App\Repositories\FileOperationRepository;


class UserDisplayService 
{
    protected $userRepository;
    protected $userOperationRepository;
    
    public function __construct(UserRepository  $userRepository,FileOperationRepository $userOperationRepository)
    {
        $this->userRepository = $userRepository;
        $this->userOperationRepository = $userOperationRepository;
    }

    public function getAllUser()
    {
        $users = $this->userRepository->getAll();
        return response()->json([
            "message" => "all Users ",
            "Users In System" => $users]);
    }


    public function showUserOperation($userId)
    {
        $historyOperation = $this->userOperationRepository->getAllById($userId);
        return response()->json([
            "message" => "all Operation for User  in system",
            "data" => $historyOperation]);
    }


    public function SearchUser($query)
    {
        $users = $this->userRepository->getUserSearch($query);
        return response()->json([
            "message" => "the User ",
            "User" => $users]);
    }
  
   
}