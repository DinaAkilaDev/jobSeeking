<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Job\applyJobRequest;
use App\Http\Requests\Job\editStatusRequest;
use App\Http\Requests\Job\jobRequest;
use App\Http\Requests\Job\SearchRequest;
use App\Repositories\JobEloquent;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function __construct(JobEloquent $jobEloquent)
    {
        $this->job = $jobEloquent;
    }

    public function search(SearchRequest $request)
    {
        return $this->job->search($request->all());
    }

    public function show()
    {
        return $this->job->show();
    }

    public function add(jobRequest $request)
    {
        return $this->job->add($request->all());
    }

    public function applyJob(applyJobRequest $request)
    {
        return $this->job->applyJob($request->all());
    }

    public function userApply(applyJobRequest $request)
    {
        return $this->job->userapply($request->all());
    }

    public function editStatus(editStatusRequest $request)
    {
        return $this->job->editStatus($request->all());
    }

}
