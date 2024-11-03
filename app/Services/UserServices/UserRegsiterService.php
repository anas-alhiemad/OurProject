<?php
namespace App\Services\UserServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\verificationEmail;
use App\Models\User;
use Validator;
class UserRegsiterService 
{
    protected $model;
    function __construct()
    {
        $this->model = new User;
    }

 
    function validation ($request){
        $validator = Validator::make($request->all(),$request->rules());
         if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
         return $validator;
        }

    function store($userdata,$request){
            $user = $this ->model->create(array_merge(
                $userdata->validated(),
                ['password' => bcrypt($request->password),
                 'photo' => $request->file('photo')->store('userPhotos')
                ]
            ));
            return $user ->email;
        }



    function generateToken($email){
        $userToken = substr(md5(rand(0,9).$email. time()),0,32);
        $user = $this ->model->whereEmail($email)->first();
        $user ->verification_token = $userToken ;
        $user ->save();
        return $user;
         }




    function SendEmail($user){
        Mail::to($user ->email)->send(new verificationEmail($user));
        
    }



    function  register($request){

        try {
            DB::beginTransaction();
            $data = $this->validation($request);
            $email = $this->Store($data,$request);
            $user = $this->generateToken($email);
            $this->SendEmail($user);
            DB::commit();
            return response()->json(["Message"=>"account has been created please check your email"]);
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }

} 








}    