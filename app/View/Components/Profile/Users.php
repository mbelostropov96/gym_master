<?php

namespace App\View\Components\Profile;

use App\Enums\UserRole;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Users extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.profile.users');
    }

    public function shouldRender() : bool
    {
        return Auth::user()->role === UserRole::ADMIN->value;
    }
}
