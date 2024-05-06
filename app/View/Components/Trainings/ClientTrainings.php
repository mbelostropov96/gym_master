<?php

namespace App\View\Components\Trainings;

use App\Enums\UserRole;
use App\Helpers\UserHelper;
use App\Models\Training;
use App\Services\DTO\UserDTO;
use App\View\ComponentTraits\HasTableTrait;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class ClientTrainings extends Component
{
    use HasTableTrait;

    public function __construct(
        public readonly Collection $trainings,
    ) {
        $this->attributeNameMap = [
            'datetime_start' => __('gym.training_start'),
            'datetime_end' => __('gym.training_end'),
            'name' => __('gym.training_name'),
            'type' => __('gym.training_type'),
            'price' => __('gym.training_price'),
            'instructor_name' =>  __('gym.instructor_name'),
            'energy_consumption' => __('gym.calories_consumption'),
            'max_clients' => __('gym.max_participants'),
        ];
        $this->clickableRouteWithId = 'trainings.show';
        $this->columnsName = $this->attributeNameMap;
        $this->columns = array_flip($this->attributeNameMap);

        $this->trainings->each(static function (Training $training) {
            $training->instructor_name = UserHelper::getFullName(new UserDTO($training->instructor->toArray()));
        });
    }

    public function render(): View|Closure|string
    {
        return view('components.trainings.index');
    }

    public function shouldRender(): bool
    {
        return Auth::user()->role === UserRole::CLIENT->value;
    }
}
