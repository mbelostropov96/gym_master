<?php

namespace App\View\Components\Admin\User;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserCard extends Component
{

    public function __construct(
        public User $user
    ) {}


    public function render(): View|Closure|string
    {
        return view('components.admin.user.user-card');
    }
}
