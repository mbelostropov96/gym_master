<?php

namespace App\View\Components\Admin\User;

use App\View\ComponentTraits\HasTableTrait;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Users extends Component
{
    use HasTableTrait;

    public function __construct(
        public readonly Collection $users
    ) {
        $this->prepareTableData(
            'admin.users.show',
            [
                'id' => 'ID',
                'last_name' => __('gym.last_name'),
                'first_name' => __('gym.first_name'),
                'middle_name' => __('gym.middle_name'),
                'email' => __('gym.email'),
                'role' => __('gym.role'),
            ]
        );
    }


    public function render(): View|Closure|string
    {
        return view('components.admin.users.index');
    }
}
