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
        if ($statusCode != 200) {
            $data = [
                'status' => false,
                'statusCode' => $statusCode,
                'message' => $response->message,
                'items' => $response,

            ];
            return response()->json($data);

        }

        $token = $response->access_token;
        \request()->headers->set('Authorization', 'Bearer ' . $token);

        $proxy = Request::create('api/profile', 'GET');
        $response = Route::dispatch($proxy);

        $statusCode = $response->getStatusCode();
        $response = json_decode($response->getContent());
        $user = \auth()->user();
        $data = [
            'status' => true,
            'statusCode' => $statusCode,
            'message' => 'Successfully Login!',
            'items' => [
                'token' => $token,
                'user' => $user,
            ],

        ];
        return response()->json($data);
    }

    public function profile($id = null)
    {
        if (isset($id)) {
            $user = User::find($id);
            if (!isset($user)) {
                $data = [
                    'status' => false,
                    'statusCode' => 422,
                    'message' => 'Error',
                    'items' => new \stdClass(),

                ];

                return response()->json($data);
            }
        }
        $user = isset($id) ? $user : \auth()->user();
        $data = [
            'status' => true,
            'statusCode' => 200,
            'message' => 'Success',
            'items' => new profileResource($user)

        ];

        return response()->json($data);

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
        $data = [
            'status' => true,
            'statusCode' => 200,
            'message' => 'Successfully Register!',
            'items' => $user->fresh(),

        ];
        return response()->json($data);
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
        $data = [
            'status' => true,
            'statusCode' => 200,
            'message' => 'Successfully Updated!',
            'items' => [
                'profile' => new userResource($user),
            ],

        ];
        return response()->json($data);
    }

    public function addsocial(array $data)
    {
        if (\auth()->user()->type === 'candidate') {
            $social = new User_social();
            $social->link = $data['link'];
            $social->type = $data['type'];
            $social->user_id = \auth()->user()->id;
            $social->save();
            $data = [
                'status' => true,
                'statusCode' => 200,
                'message' => 'Successfully Added!',
                'items' => [
                    'social' => new socialResource($social),
                ],

            ];
            return response()->json($data);
        } else {
            $data = [
                'status' => false,
                'statusCode' => 500,
                'message' => 'Unauthorized to be here!',
                'items' => '',

            ];
            return response()->json($data);
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
            $data = [
                'status' => true,
                'statusCode' => 200,
                'message' => 'Successfully Added!',
                'items' => [
                    'experience' => new experienceResource($experience),
                ],

            ];
            return response()->json($data);
        } else {
            $data = [
                'status' => false,
                'statusCode' => 500,
                'message' => 'Unauthorized to be here!',
                'items' => '',

            ];
            return response()->json($data);
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
            $data = [
                'status' => true,
                'statusCode' => 200,
                'message' => 'Successfully Added!',
                'items' => [
                    'education' => new educationResource($education),
                ],

            ];
            return response()->json($data);
        } else {
            $data = [
                'status' => false,
                'statusCode' => 500,
                'message' => 'Unauthorized to be here!',
                'items' => '',

            ];
            return response()->json($data);
        }
    }
    public function verifcation_code(){
        $data = [
            'status' => true,
            'statusCode' => 200,
            'message' => 'Success!',
            'items' => [
                'verifcation_code' => Auth::user()->verifcation_code,
            ],

        ];
        return response()->json($data);
    }
    public function verify(array $data){
        if ($data['verifcation_code']== Auth::user()->verifcation_code){
            $id = auth()->user()->id;
            $user = User::find($id);
            $user->is_verify = true;
            $user->save();
            $data = [
                'status' => true,
                'statusCode' => 200,
                'message' => 'Phone Verified Successfully!',
                'items' => '',

            ];
            return response()->json($data);
        }
        $data = [
            'status' => false,
            'statusCode' => 500,
            'message' => 'Bad Verifcation Code!',
            'items' => '',

        ];
        return response()->json($data);
    }


}
