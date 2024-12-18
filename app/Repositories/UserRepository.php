<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\RepositoryInterface;

class UserRepository extends BaseRepository implements RepositoryInterface
{
    
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function storeToken($userEmail)
    {
        $userToken = mt_rand(10000, 99999);
        $user = $this ->model->whereEmail($userEmail)->first();
        $user ->verification_token = $userToken ;
        $user ->save();
        return $user;
    }


    public function checkToken($token)
    {
        $user = $this->model->whereVerification_token($token)->first();
        if (!$user){
            return response()->json(["Message" => "this token is invalid"], 400);}
            
        $user->verification_token = null;
        $user->email_verified_at = now();
        $user->save();

        return response()->json(["Message" => "your account has been verified "], 200);
    }


    function GetUserStatus($email)
    {
        $user = $this->model->whereEmail($email)->first();
        $status = $user->status;
        return $status;
    }


    function getVerify($email)
    {
        $user = $this->model->whereEmail($email)->first();
        $verified = $user->email_verified_at;
        return $verified;
    }


    function accountStatus($userId)  
    {
        $user =$this->model->whereId($userId)->first();
            if (!$user){
                return response()->json(["Message" => "this Id is invalid"], 400);
                }
        $user->status = true;
        $user->save();
        return response()->json(['message' => 'User successfully change status']);
    }
}
