<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;
    protected $fillable = [
        'groupId',
        'invitedUserId',
        'status',
    ];


    public function group()
    {
        return $this->belongsTo(Group::class,'groupId');
    }

    public function invitedUser()
    {
        return $this->belongsTo(User::class, 'invitedUserId');
    }

    public function inviter()
    {
        return $this->belongsTo(User::class, 'ByInviterUserId');
    }
}
