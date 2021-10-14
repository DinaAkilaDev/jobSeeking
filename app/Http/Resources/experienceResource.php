<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class experienceResource extends JsonResource
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
            'bio'=>$this->bio,
            'user'=>new userResource($this->User),

        ];
    }
}
