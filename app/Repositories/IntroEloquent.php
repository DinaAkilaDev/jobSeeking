<?php

namespace App\Repositories;

use App\Http\Resources\introResource;
use App\Models\Intro;

class IntroEloquent
{
    public function __construct(Intro $intro)
    {
        $this->model = $intro;
    }

    public function show(){
        $page_number = intval( \request()->get('page_number'));
        $page_size = \request()->get('page_size');
        $total_records = Intro::count();
        $total_pages = ceil($total_records / $page_size);
        $intro = Intro::skip(($page_number - 1) * $page_size)
            ->take($page_size)->get();
        return response_api(true,200,'Success',introResource::collection($intro), $page_number,$total_pages,$total_records);
    }
}
