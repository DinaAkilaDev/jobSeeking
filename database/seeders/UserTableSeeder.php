<?php

namespace Database\Seeders;

use App\Models\Intro;
use App\Models\Job;
use App\Models\Job_skill;
use App\Models\Skill;
use App\Models\User;
use App\Models\User_education;
use App\Models\User_experience;
use App\Models\User_job;
use App\Models\User_social;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        `first_name`, `last_name`, `email`, `country_code`, `phone`, `password`, `photo`, `type`, `verifcation_code`, `is_verify`, `company_name`, `bio`
        $user=new User();
        $user->first_name='Dina';
        $user->last_name='Akila';
        $user->email='dinashadiakeela@gmail.com';
        $user->country_code='+970';
        $user->phone='597505581';
        $user->password=bcrypt('123456');
        $user->photo='https://i.pinimg.com/originals/bc/ed/58/bced58f3a6e8438485e7f5ccb65e52c7.png';
        $user->type='candidate';
        $user->verifcation_code=null;
        $user->company_name=null;
        $user->bio=null;
        $user->save();

//        `title`, `description`, `education`, `type`, `level`, `location`
        $job=new Job();
        $job->title='web development';
        $job->description='plplfdlpkfdjlpdfkpmdfblmkp ';
        $job->education='ijweiflrfkfull';
        $job->type='full';
        $job->level='intermediate';
        $job->location='london';
        $job->save();


        $intro=new Intro();
        $intro->title='web development';
        $intro->description='plplfdlpkfdjlpdfkpmdfblmkp ';
        $intro->image='https://i.pinimg.com/originals/bc/ed/58/bced58f3a6e8438485e7f5ccb65e52c7.png';
        $intro->save();

        $skill=new Skill();
        $skill->name='laravel';
        $skill->save();


        $user_social=new User_social();
        $user_social->link='https://www.facebook.com/';
        $user_social->type='facebook';
        $user_social->user_id=$user->id;
        $user_social->save();


        $user_experience=new User_experience();
        $user_experience->title='web development';
        $user_experience->bio='efrhuihgerfjdikfjldskplpdkwaokfgodkv';
        $user_experience->user_id=$user->id;
        $user_experience->save();

        $user_education=new User_education();
        $user_education->title='web development';
        $user_education->bio='efrhuihgerfjdikfjldskplpdkwaokfgodkv';
        $user_education->icon='https://i.pinimg.com/originals/bc/ed/58/bced58f3a6e8438485e7f5ccb65e52c7.png';
        $user_education->user_id=$user->id;
        $user_education->save();

        $User_job=new User_job();
        $User_job->user_id=$user->id;
        $User_job->job_id=$job->id;
        $User_job->status='accepted';
        $User_job->save();

        $job_skill=new Job_skill();
        $job_skill->job_id=$job->id;
        $job_skill->skill_id=$skill->id;
        $job_skill->save();






    }
}
