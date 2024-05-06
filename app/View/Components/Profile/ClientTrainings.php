<?php

namespace App\View\Components\Profile;

use App\Enums\UserRole;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class ClientTrainings extends Component
{
    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.profile.client-trainings');
    }

    public function shouldRender() : bool
    {
        return Auth::user()->role === UserRole::CLIENT->value;
    }
}
