<?php
namespace App\Services\UserServices;
use Exception;

use App\Models\User;
use App\Mail\verificationEmail;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserRegsiterService 
{

    protected $userRepository;
    
    public function __construct(UserRepository  $userRepository)
    {
        $this->userRepository = $userRepository;
    }




    function validation ($request)
    {
        $validator = Validator::make($request->all(),$request->rules());
         if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
         return $validator;
    }




    function store($userdata,$request)
    {
        $user = array_merge($userdata->validated(),
            ['password' => bcrypt($request->password),
            'photo' => 'upload/'.$request->file('photo')->store('userPhoto','public_upload')
            ]);

        $userCreated = $this->userRepository->create($user);    
        return $userCreated;
    }



    function generateToken($userEmail)
    {
        $user =  $this->userRepository->storeToken($userEmail);
        return $user;
    }




    function SendEmail($user)
    {
        Mail::to($user ->email)->send(new verificationEmail($user));
        
    }



    function  register($request)
    {
            $data = $this->validation($request);
            
            $user = $this->store($data,$request);
        
            //    return throw new \Exception('Test error to trigger rollback');
            
            $userToken = $this->generateToken($user->email);
            
            $this->SendEmail($userToken);
            
            return response()->json(["Message"=>"account has been created please check your email","User"=>$user]);

    }
    
    



    public function verifyAccount($code)
    {
        $response =  $this->userRepository->checkToken($code);
        return $response;
    }





}    