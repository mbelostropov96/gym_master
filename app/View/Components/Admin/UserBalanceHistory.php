<?php

namespace App\View\Components\Admin;

use App\Enums\UserRole;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class UserBalanceHistory extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public User $user
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.user.user-balance-history');
    }

    public function shouldRender() : bool
    {
        return $this->user->role === UserRole::CLIENT->value;
    }
}
