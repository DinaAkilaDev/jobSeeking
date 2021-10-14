<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class profileResource extends JsonResource
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
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'photo'=>$this->photo,
            'bio'=>$this->bio,
            'phone'=>$this->phone,
            'education'=> educationsResource::collection($this->Educations),
            'experience'=>experiencesResource::collection($this->Experiences),
            'social'=>socialsResource::collection($this->Socials),
        ];
    }
}
