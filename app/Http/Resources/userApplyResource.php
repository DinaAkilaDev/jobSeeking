<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\User_job;
use Illuminate\Http\Resources\Json\JsonResource;

class userApplyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'title'=>$this->title,
            'description'=>$this->description,
            'education'=>$this->education,
            'type'=>$this->type,
            'level'=>$this->level,
            'location'=>$this->location,
            'skills'=>skillResource::collection($this->Skills),
            'users'=> userResource::collection($this->Users),

            ];
    }
}
