<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\IntroEloquent;
use Illuminate\Http\Request;

class IntroController extends Controller
{
    public function __construct(IntroEloquent $introEloquent)
    {
        $this->intro = $introEloquent;
    }

    public function show()
    {
        return $this->intro->show();
    }
}
