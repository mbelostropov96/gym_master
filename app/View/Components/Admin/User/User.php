<?php

namespace App\View\Components\Admin\User;

use App\Models\User as UserModel;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class User extends Component
{
    public function __construct(
        public UserModel $userModel
    ) {
    }


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
