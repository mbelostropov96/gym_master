<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
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
        $tariffs = (new Tariff())->newQuery()
            ->orderBy('discount')
            ->get();

        $profileComponent = new Profile($tariffs);

        return $profileComponent->render()->with($profileComponent->data());
    }
}
