<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class userResource extends JsonResource
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
            'country_code'=>$this->country_code,
            'phone'=>$this->phone,
            'photo'=>$this->photo,
            'type'=>$this->type,
            'company_name'=>$this->company_name,
            'bio'=>$this->bio,
        ];
    }
}
