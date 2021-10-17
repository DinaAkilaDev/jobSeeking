<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\profileRequest;
use App\Http\Requests\User\SignupRequest;
use \App\Http\Requests\User\verifcationCodeRequest;
use App\Repositories\UserEloquent;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(UserEloquent $userEloquent)
    {
        $this->user = $userEloquent;
    }

    public function login()
    {
        return $this->user->login();
    }

    public function register(SignupRequest $request)
    {
        return $this->user->register($request->all());

    }

    public function profile($id = null)
    {
        return $this->user->profile($id);
    }

    public function edit(profileRequest $request)
    {
        return $this->user->edit($request->all());
    }

    public function addSocial(profileRequest $request)
    {
        return $this->user->addsocial($request->all());
    }

    public function addExperience(profileRequest $request)
    {
        return $this->user->addexperience($request->all());
    }

    public function addEducation(profileRequest $request)
    {
        return $this->user->addeducation($request->all());
    }

    public function verifcation_code()
    {
        return $this->user->verifcation_code();
    }

    public function verify(verifcationCodeRequest $request)
    {
        return $this->user->verify($request->all());
    }
}
