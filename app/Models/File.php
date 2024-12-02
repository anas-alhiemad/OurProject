<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name', 'file_path', 'is_checked_in'];
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
