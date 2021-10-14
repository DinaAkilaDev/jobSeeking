<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_social extends Model
{
    use HasFactory;
    public function User(){
        return $this->belongsTo(User::class,'user_id');
    }
}
