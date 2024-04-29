<?php

namespace App\View\Components\Admin;

use App\Models\User as UserModel;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class User extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public UserModel $userModel
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view(
            'components.admin.user.index',
            [
                'user' => $this->userModel
            ]
        );
    }
}
