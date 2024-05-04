<?php

use App\Http\Controllers\Admin\ReservationAdminController;
use App\Http\Controllers\Admin\TrainingAdminController;
use App\Http\Controllers\Admin\TrainingTemplateAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Client\ReservationClientController;
use App\Http\Controllers\Client\TrainingClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;

/** @var Router $router */
$router = app('router');

Auth::routes();

$router->get('/', function () {
    return redirect('/profile');
});

$router->get('/profile', [HomeController::class, 'index'])->name('profile');

$router->get('/users/{id}', [UserController::class, 'show'])->name('users.show');
$router->patch('/users/{id}', [UserController::class, 'update'])->name('users.update');
$router->delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

$router->group([
    'middleware' => 'admin',
    'prefix' => 'admin',
], function () use ($router) {
    $router->get('/users', [UserAdminController::class, 'index'])->name('admin.users.index');
    $router->get('/users/{id}', [UserAdminController::class, 'show'])->name('admin.users.show');
    $router->patch('/users/{id}', [UserAdminController::class, 'update'])->name('admin.users.update');
    $router->patch('/users/balance/{id}', [UserAdminController::class, 'updateBalance'])->name('admin.users.balance.update');
    $router->delete('/users/{id}', [UserAdminController::class, 'destroy'])->name('admin.users.destroy');

    $router->get('/training-templates', [TrainingTemplateAdminController::class, 'index'])->name('admin.training-templates.index');
    $router->get('/training-templates/{id}', [TrainingTemplateAdminController::class, 'show'])->name('admin.training-templates.show')
        ->where('id', '[0-9]+');
    $router->get('/training-templates/create', [TrainingTemplateAdminController::class, 'create'])->name('admin.training-templates.create');
    $router->post('/training-templates', [TrainingTemplateAdminController::class, 'store'])->name('admin.training-templates.store');
    $router->patch('/training-templates/{id}', [TrainingTemplateAdminController::class, 'update'])->name('admin.training-templates.update');
    $router->delete('/training-templates/{id}', [TrainingTemplateAdminController::class, 'destroy'])->name('admin.training-templates.destroy');

    $router->get('/trainings', [TrainingAdminController::class, 'index'])->name('admin.trainings.index');
    $router->get('/trainings/{id}', [TrainingAdminController::class, 'show'])->name('admin.trainings.show')
        ->where('id', '[0-9]+');
    $router->get('/trainings/create', [TrainingAdminController::class, 'create'])->name('admin.trainings.create');
    $router->get('/trainings/create-by-template', [TrainingAdminController::class, 'createByTemplate'])->name('admin.create-by-template.create');
    $router->post('/trainings', [TrainingAdminController::class, 'store'])->name('admin.trainings.store');
    $router->patch('/trainings/{id}', [TrainingAdminController::class, 'update'])->name('admin.trainings.update');
    $router->delete('/trainings/{id}', [TrainingAdminController::class, 'destroy'])->name('admin.trainings.destroy');

    $router->delete('/reservations/{id}', [ReservationAdminController::class, 'destroy'])->name('admin.reservations.destroy');
});

$router->group([
    'middleware' => 'client',
], function () use ($router) {
    $router->get('/trainings', [TrainingClientController::class, 'index'])->name('trainings.index');
    $router->get('/trainings/{id}', [TrainingClientController::class, 'show'])->name('trainings.show');

    $router->get('/reservations', [ReservationClientController::class, 'index'])->name('reservations.index');
    $router->post('/reservations', [ReservationClientController::class, 'store'])->name('reservations.store');
    $router->delete('/reservations/{id}', [ReservationClientController::class, 'destroy'])->name('reservations.destroy');
});
