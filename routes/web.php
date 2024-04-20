<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;

/** @var Router $router */
$router = app('router');

Auth::routes();

$router->get('/', function () {
    return view('welcome');
});
$router->get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
