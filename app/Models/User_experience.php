<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_experience extends Model
{
    use HasFactory;
    public function User(){
        return $this->belongsTo(User::class,'user_id');
    }
}
