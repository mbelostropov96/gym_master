<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;

/** @var Router $router */
$router = app('router');

Auth::routes();

$router->get('/', function () {
    return view('welcome');
});
$router->get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

$router->group([
    'middleware' => 'admin',
    'prefix' => 'admin',
], function () use ($router) {
    $router->get('users', [UserController::class, 'index'])->name('users.index');
    $router->get('users/{id}', [UserController::class, 'show'])->name('users.show');
    $router->patch('users/{id}', [UserController::class, 'update'])->name('users.update');
    $router->delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});
