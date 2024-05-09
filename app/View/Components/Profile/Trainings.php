<?php

namespace App\View\Components\Profile;

use App\Enums\UserRole;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Trainings extends Component
{
    public string $route;

    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        $this->route = match (Auth::user()->role) {
            UserRole::ADMIN->value => 'admin.trainings.index',
            UserRole::INSTRUCTOR->value => 'instructor.trainings.index',
        };

        return view('components.profile.trainings');
    }

    public function shouldRender(): bool
    {
        return Auth::user()->role !== UserRole::CLIENT->value;
    }
}
