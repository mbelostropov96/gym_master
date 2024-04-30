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

    $router->get('training-templates', [TrainingTemplateAdminController::class, 'index'])->name('training-templates.index');
    $router->get('training-templates/{id}', [TrainingTemplateAdminController::class, 'show'])->name('training-templates.show')
        ->where('id', '[0-9]+');
    $router->get('training-templates/create', [TrainingTemplateAdminController::class, 'create'])->name('training-templates.create');
    $router->post('training-templates', [TrainingTemplateAdminController::class, 'store'])->name('training-templates.store');
    $router->patch('training-templates/{id}', [TrainingTemplateAdminController::class, 'update'])->name('training-templates.update');
    $router->delete('training-templates/{id}', [TrainingTemplateAdminController::class, 'destroy'])->name('training-templates.destroy');

    $router->get('trainings', [TrainingAdminController::class, 'index'])->name('trainings.index');
    $router->get('trainings/{id}', [TrainingAdminController::class, 'show'])->name('trainings.show')
        ->where('id', '[0-9]+');
    $router->get('trainings/create', [TrainingAdminController::class, 'create'])->name('trainings.create');
    $router->get('trainings/create-by-template', [TrainingAdminController::class, 'createByTemplate'])->name('create-by-template.create');
    $router->post('trainings', [TrainingAdminController::class, 'store'])->name('trainings.store');
    $router->patch('trainings/{id}', [TrainingAdminController::class, 'update'])->name('trainings.update');
    $router->delete('trainings/{id}', [TrainingAdminController::class, 'destroy'])->name('trainings.destroy');
});
