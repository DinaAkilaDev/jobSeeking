<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class userJobResource extends JsonResource
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
            'user'=> new userResource($this->User),
            'job'=> new jobResource($this->Job),
            'status'=> $this->status,
        ];
    }
}
