<?php

namespace App\Models;

use App\Models\UserGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;
    protected $fillable = [
        'nameGroup',
        'description',
        'created_by',
    ];


    public function userGroup(){
        return $this->hasMany(UserGroup::class,'groupId');
    }
    

    public function invitation(){
        return $this->hasMany(Invitation::class,'groupId');
    }
    
}
