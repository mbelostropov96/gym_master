<?php

use App\Http\Controllers\Admin\TrainingAdminController;
use App\Http\Controllers\Admin\UserAdminController;
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
    $router->get('users', [UserAdminController::class, 'index'])->name('users.index');
    $router->get('users/{id}', [UserAdminController::class, 'show'])->name('users.show');
    $router->patch('users/{id}', [UserAdminController::class, 'update'])->name('users.update');
    $router->delete('users/{id}', [UserAdminController::class, 'destroy'])->name('users.destroy');

    $router->get('trainings', [TrainingAdminController::class, 'index'])->name('trainings.index');
    $router->get('trainings/{id}', [TrainingAdminController::class, 'show'])->name('trainings.show');
    $router->post('trainings', [TrainingAdminController::class, 'store'])->name('trainings.store');
    $router->patch('trainings/{id}', [TrainingAdminController::class, 'update'])->name('trainings.update');
    $router->delete('trainings/{id}', [TrainingAdminController::class, 'destroy'])->name('trainings.destroy');
});
