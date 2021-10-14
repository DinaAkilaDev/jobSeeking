<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_job extends Model
{
    use HasFactory;
    public function User(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function Job(){
        return $this->belongsTo(Job::class,'job_id');
    }
}
