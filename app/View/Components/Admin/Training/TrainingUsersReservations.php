<?php

namespace App\View\Components\Admin\Training;

use App\Helpers\UserHelper;
use App\Models\User;
use App\Services\DTO\UserDTO;
use App\View\ComponentTraits\HasTableTrait;
use App\View\ValueObject\TableButtonAction;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class TrainingUsersReservations extends Component
{
    use HasTableTrait;

    public Collection $users;

    public function __construct(
        public \App\Models\Training $training,
    ) {
        $this->users = $this->training->clients;
        $this->attributeNameMap = [
            'id' => 'ID',
            'full_name' => __('gym.client_name'),
        ];

        array_map(
            static function (User $user) use ($training) {
                $user->full_name = UserHelper::getFullName(
                    new UserDTO([
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'middle_name' => $user->middle_name,
                    ]));
                $user->reservation_id = $training->reservations->where('client_id', $user->id)->first()->id;
            },
            $this->users->all(),
        );

        $this->clickableRouteWithId = 'admin.users.show';
        $this->columnsName = $this->attributeNameMap;
        $this->columns = array_flip($this->attributeNameMap);

        $this->actions = [
            new TableButtonAction(
                __('gym.cancel_reservation'),
                'admin.reservations.destroy',
                ['id' => 'reservation_id'],
                'DELETE',
                'danger',
            ),
        ];
    }

    public function render(): View|Closure|string
    {
        return view('components.admin.training.training-users-reservations');
    }
}
