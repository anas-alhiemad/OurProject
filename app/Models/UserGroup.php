<?php

namespace App\Models;

use App\Models\User;
use App\Models\Group;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserGroup extends Model
{
    use HasFactory;
    protected $fillable = ['userId','groupId','isOwner'];

    public function group(){
        return $this->belongsto(Group::class,'groupId');
    }
    
    public function user(){
        return $this->belongsto(User::class,'userId');
    }
    
}
