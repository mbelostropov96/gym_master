<?php

namespace App\Http\Controllers;

use App\View\Components\Profile\Profile;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function profile(): Renderable
    {
        return (new Profile())->render();
    }
}
