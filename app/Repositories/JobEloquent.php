<?php

namespace App\Repositories;

use App\Http\Resources\jobResource;
use App\Http\Resources\userApplyResource;
use App\Http\Resources\userJobResource;
use App\Models\Job;
use App\Models\Job_skill;
use App\Models\Skill;
use App\Models\Skills;
use App\Models\User;
use App\Models\User_job;
use App\Notifications\NewJobNotification;
use \Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class JobEloquent
{
    private $model;

    public function __construct(Job $job)
    {
        $this->model = $job;
    }

    public function search(array $data)
    {
        $job_name = $data['name'];
        $job = Job::where("title", "like", "%$job_name%")->first();
        $data = [
            'status' => true,
            'statusCode' => 200,
            'message' => 'Success',
            'items' => new jobResource($job)

        ];

        return response()->json($data);
    }

    public function show()
    {
        $page_number = intval(\request()->get('page_number'));
        $page_size = \request()->get('page_size');
        $total_records = Job::count();
        $total_pages = ceil($total_records / $page_size);
        $jobs = Job::skip(($page_number - 1) * $page_size)
            ->take($page_size)->get();
        $data = [
            'status' => true,
            'statusCode' => 200,
            'message' => 'Success',
            'items' => [
                'data' => userApplyResource::collection($jobs),
                "page_number" => $page_number,
                "total_pages" => $total_pages,
                "total_records" => $total_records,

            ]

        ];

        return response()->json($data);
    }

    public function add(array $data)
    {
        if (Auth::user()->type === 'company') {
            $skill = new Skill();
            $skill->name = $data['skill_name'];
            $skill->save();

            $job = new Job();
            $job->title = $data['title'];
            $job->description = $data['description'];
            $job->education = $data['education'];
            $job->type = $data['type'];
            $job->level = $data['level'];
            $job->location = $data['location'];
            $job->save();

            $job_skill = new Job_skill();
            $job_skill->job_id = $job->id;
            $job_skill->skill_id = $skill->id;
            $job_skill->save();

            $data = [
                'status' => true,
                'statusCode' => 200,
                'message' => 'Successfully Added!',
                'items' => [
                    'project' => new jobResource($job),
                ],

            ];
            $users = User::where('type', 'candidate')->get();
            Notification::send($users, new NewJobNotification($job));
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

    public function applyJob(array $data)
    {
        if (Auth::user()->type === 'candidate') {
            if (Job::find($data['job_id']) != null) {
                $user_accept=User_job::where('job_id',$data['job_id'])->first();
                if ($user_accept->status =='accepted'){
                    $data = [
                        'status' => false,
                        'statusCode' => 500,
                        'message' => 'You can not apply for this job!',
                        'items' => '',

                    ];
                    return response()->json($data);
                }
                $user_job = new User_job();
                $user_job->user_id = \auth()->user()->id;
                $user_job->job_id = $data['job_id'];
                $user_job->status = 'pending';
                $user_job->save();
                $data = [
                    'status' => true,
                    'statusCode' => 200,
                    'message' => 'Successfully Apply!',
                    'items' => [
                        'project' => new userJobResource($user_job),
                    ],

                ];
                return response()->json($data);
            } else {
                $data = [
                    'status' => false,
                    'statusCode' => 500,
                    'message' => 'There is no job with this id!',
                    'items' => '',

                ];
                return response()->json($data);

            }
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

    public function userapply(array $data)
    {
        if (Auth::user()->type === 'company') {
            $job = Job::find($data['job_id']);
            if ($job != null) {
                $data = [
                    'status' => true,
                    'statusCode' => 200,
                    'message' => 'Success',
                    'items' => [
                        'data' => new userApplyResource($job),

                    ]

                ];

                return response()->json($data);
            } else {
                $data = [
                    'status' => false,
                    'statusCode' => 500,
                    'message' => 'There is no job with this id!',
                    'items' => '',

                ];
                return response()->json($data);
            }
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
    public function editStatus(array  $data){
        if (Auth::user()->type === 'company') {
            $job = Job::find($data['job_id']);
            if ($job != null) {
                $user_job=User_job::where('job_id',$data['job_id'])->where('user_id',$data['user_id'])->first();
                $user_job->status=$data['status'];
                $user_job->save();
                $data = [
                    'status' => true,
                    'statusCode' => 200,
                    'message' => 'Success',
                    'items' => [
                        'data' => new userJobResource($user_job),

                    ]

                ];

                return response()->json($data);
            } else {
                $data = [
                    'status' => false,
                    'statusCode' => 500,
                    'message' => 'There is no job with this id!',
                    'items' => '',

                ];
                return response()->json($data);
            }
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


}
