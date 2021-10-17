<?php

namespace App\Repositories;

use App\Http\Resources\educationResource;
use App\Http\Resources\experienceResource;
use App\Http\Resources\profileResource;
use App\Http\Resources\socialResource;
use App\Http\Resources\userResource;
use App\Models\Profile;
use App\Models\User;
use App\Models\User_education;
use App\Models\User_experience;
use App\Models\User_social;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Twilio\Rest\Client;

class UserEloquent
{
    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function login()
    {
        $proxy = Request::create('oauth/token', 'POST');
        $response = Route::dispatch($proxy);
        $statusCode = $response->getStatusCode();
        $response = json_decode($response->getContent());
        if ($statusCode != 200)
            return response_api(false, $statusCode, $response->message, $response);


        $token = $response->access_token;
        \request()->headers->set('Authorization', 'Bearer ' . $token);

        $proxy = Request::create('api/profile', 'GET');
        $response = Route::dispatch($proxy);

        $statusCode = $response->getStatusCode();
        $user = \auth()->user();

        return response_api(true, $statusCode, 'Successfully Login', ['token' => $token, 'user' => $user]);

    }

    public function profile($id = null)
    {
        if (isset($id)) {
            $user = User::find($id);
            if (!isset($user)) {
                return response_api(false, 422, 'Error', new \stdClass());

            }

        }
        $user = isset($id) ? $user : \auth()->user();
        return response_api(true, 200, 'Success', new profileResource($user));


    }

    public function generateCode($num = 4)
    {
        $code = '';
        for ($i = 0; $i < $num; $i++) {
            $code .= rand(0, 9);
        }
        return $code;
    }

    public function register(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        $data['verifcation_code'] = $this->generateCode();

        $user = User::create($data);
        return response_api(true, 200, 'Successfully Register!', $user->fresh());

    }

    public function edit(array $data)
    {
        $id = auth()->user()->id;
        $user = User::find($id);
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        if ($data['email'] != null) {
            $user->email = $data['email'];
        }
        $user->country_code = $data['country_code'];
        $user->phone = $data['phone'];
        if ($data['password'] != null) {
            $user->password = bcrypt($data['password']);
        }
        if ($data['photo'] != null) {
            $user->photo = $data['photo'];
        }

        if ($data['type'] != null) {
            $user->type = $data['type'];
        }
        if ($data['company_name'] != null) {
            $user->company_name = $data['company_name'];
        }
        $user->bio = $data['bio'];
        $user->save();
        return response_api(true, 200, 'Successfully Updated!', ['profile' => new userResource($user)]);

    }

    public function addsocial(array $data)
    {
        if (\auth()->user()->type === 'candidate') {
            $social = new User_social();
            $social->link = $data['link'];
            $social->type = $data['type'];
            $social->user_id = \auth()->user()->id;
            $social->save();
            return response_api(true, 200, 'Successfully Added!', ['social' => new socialResource($social)]);

        } else {
            return response_api(false, 500, 'Unauthorized to be here!', '');

        }
    }

    public function addexperience(array $data)
    {
        if (\auth()->user()->type === 'candidate') {
            $experience = new User_experience();
            $experience->title = $data['title'];
            $experience->bio = $data['bio'];
            $experience->user_id = \auth()->user()->id;
            $experience->save();

            return response_api(true, 200, 'Successfully Added!', ['experience' => new experienceResource($experience),]);

        } else {
            return response_api(false, 500, 'Unauthorized to be here!', '');

        }
    }

    public function addeducation(array $data)
    {
        if (\auth()->user()->type === 'candidate') {
            $education = new User_education();
            $education->title = $data['title'];
            $education->bio = $data['bio'];
            $education->icon = $data['icon'];
            $education->user_id = \auth()->user()->id;
            $education->save();
            return response_api(true, 200, 'Successfully Added!', ['education' => new educationResource($education)]);

        } else {
            return response_api(false, 500, 'Unauthorized to be here!', '');

        }
    }

    public function verifcation_code()
    {
        return response_api(true, 200, 'Success!',['verifcation_code' => Auth::user()->verifcation_code]);

    }

    public function verify(array $data)
    {
        if ($data['verifcation_code'] == Auth::user()->verifcation_code) {
            $user = auth()->user();
            $user->is_verify = true;
            $user->save();
            return response_api(true, 200, 'Phone Verified Successfully!','');

        }
        return response_api(false, 422, 'Bad Verifcation Code!', '');

    }


}
