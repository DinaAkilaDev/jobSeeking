<?php

namespace App\Models;

use App\Notifications\NewJobNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Job extends Model
{
    use HasFactory,Notifiable;

    public function Users(){
        return $this->belongsToMany(User::class,'user_jobs','job_id','user_id');
    }
    public function Skills(){
        return $this->belongsToMany(Skill::class, 'job_skills');
    }
}
