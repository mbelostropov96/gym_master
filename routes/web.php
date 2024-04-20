<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;

/** @var Router $router */
$router = app('router');

Auth::routes();

$router->get('/', function () {
    return view('auth.login');
});

$router->get('/profile', [App\Http\Controllers\HomeController::class, 'index'])->name('profile');

$router->group([
    'middleware' => 'admin',
    'prefix' => 'admin',
], function () use ($router) {
    $router->get('user/index', [UserController::class, 'indexUser'])->name('admin.user.index');
});
