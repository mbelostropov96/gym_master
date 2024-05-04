<?php

namespace App\View\Components\Admin\User;

use App\Enums\UserRole;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserBalance extends Component
{

    public function __construct(
        public User $user
    ) {}


    public function render(): View|Closure|string
    {
        return view('components.admin.user.user-balance');
    }

    public function shouldRender() : bool
    {
        return $this->user->role === UserRole::CLIENT->value;
    }
}
