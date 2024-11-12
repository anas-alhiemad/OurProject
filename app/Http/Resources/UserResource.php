<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    protected $model = User::class;
    // function __construct(){
    //     $this -> model = new User();
    // }

    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'name'=>$this->name,
            'userName'=>$this->userName,
            'photo'=>$this->photo,
            'email'=>$this->email,
        ];
        
    }
}
