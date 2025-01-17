<?php
namespace App\Services\UserServices;

use App\Repositories\UserRepository;
use App\Repositories\GroupRepository;
use App\Repositories\GroupUserRepository;
use App\Repositories\FileOperationRepository;


class UserDisplayService 
{
    protected $userRepository;
    protected $userOperationRepository;
    protected $groupRepository;
  

    public function __construct(UserRepository  $userRepository,FileOperationRepository $userOperationRepository,GroupRepository $groupRepository)
    {
        $this->userRepository = $userRepository;
        $this->userOperationRepository = $userOperationRepository;
        $this->groupRepository = $groupRepository;
    }

    public function isOwner($user,$group)
    { 
        if ($user->can('create', $group)) 
                    return true;
        return false;            
    }

    public function getAllUser()
    {
        $users = $this->userRepository->getAll();
        return response()->json([
            "message" => "all Users ",
            "Users In System" => $users]);
    }


    public function showUserOperation($userId,$groupId)
    {
        $group = $this->groupRepository->getById($groupId);
           
        $user =  $this->userRepository->getById(auth()->guard('user')->id()); 
      
        $owner = $this->isOwner($user,$group); 
        if ($owner) {
        $historyOperation = $this->userOperationRepository->getAllById($userId,$groupId);
        return response()->json([
            "message" => "all Operation for User  in Group",
            "data" => $historyOperation]);
        }
             return response()->json(['Message' => 'You do not have the authority to Do this.'], 422);   
     
    }


    public function SearchUser($query)
    {
        $users = $this->userRepository->getUserSearch($query);
        return response()->json([
            "message" => "the User ",
            "User" => $users]);
    }
  
   
}