<?php

use App\Http\Controllers\Admin\TrainingAdminController;
use App\Http\Controllers\Admin\TrainingTemplateAdminController;
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
    $router->patch('users/balance/{id}', [UserAdminController::class, 'updateBalance'])->name('users.balance.update');
    $router->delete('users/{id}', [UserAdminController::class, 'destroy'])->name('users.destroy');

    $router->get('training-template', [TrainingTemplateAdminController::class, 'index'])->name('training-template.index');
    $router->get('training-template/{id}', [TrainingTemplateAdminController::class, 'show'])->name('training-template.show');
    $router->post('training-template', [TrainingTemplateAdminController::class, 'store'])->name('training-template.store');
    $router->patch('training-template/{id}', [TrainingTemplateAdminController::class, 'update'])->name('training-template.update');
    $router->delete('training-template/{id}', [TrainingTemplateAdminController::class, 'destroy'])->name('training-template.destroy');

    $router->get('trainings', [TrainingAdminController::class, 'index'])->name('trainings.index');
    $router->get('trainings/{id}', [TrainingAdminController::class, 'show'])->name('trainings.show');
    $router->post('trainings', [TrainingAdminController::class, 'store'])->name('trainings.store');
    $router->patch('trainings/{id}', [TrainingAdminController::class, 'update'])->name('trainings.update');
    $router->delete('trainings/{id}', [TrainingAdminController::class, 'destroy'])->name('trainings.destroy');
});
