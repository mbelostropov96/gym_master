<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;

class UserController extends Controller
{
    /**
     * @return Factory|Application|View|ApplicationContract
     */
    public function indexUser(): Factory|Application|View|ApplicationContract
    {
        $users = (new User())->newQuery()
            ->get();

        // TODO прокинуть блейд
        return view('', [
            'users' => $users,
        ]);
    }
}
