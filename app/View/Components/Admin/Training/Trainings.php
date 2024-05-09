<?php

namespace App\View\Components\Admin\Training;

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

class Trainings extends Component
{
    use HasTableTrait;

    public string $createTrainingRoute;
    public string $updateTrainingRoute;

    public function __construct(
        public readonly Collection $trainings,
    ) {
        $this->prepareRoutesByRole();
        $this->prepareTableData(
            $this->updateTrainingRoute,
            [
                'id' => 'ID',
                'name' => __('gym.training_name'),
                'type' => __('gym.training_type'),
                'price' => __('gym.training_price'),
                'datetime_start' => __('gym.training_start'),
                'datetime_end' => __('gym.training_end'),
                'instructor_name' =>  __('gym.instructor_name'),
                'energy_consumption' => __('gym.calories_consumption'),
                'max_clients' => __('gym.max_participants'),
            ]
        );

        $this->trainings->each(static function (Training $training) {
            $training->instructor_name = UserHelper::getFullName(new UserDTO($training->instructor->toArray()));
        });
    }

    private function prepareRoutesByRole(): void
    {
        $this->createTrainingRoute = match (Auth::user()->role) {
            UserRole::ADMIN->value => 'admin.trainings.create',
            UserRole::INSTRUCTOR->value => 'instructor.trainings.create',
        };
        $this->updateTrainingRoute = match (Auth::user()->role) {
            UserRole::ADMIN->value => 'admin.trainings.update',
            UserRole::INSTRUCTOR->value => 'instructor.trainings.update',
        };
    }

    public function render(): View|Closure|string
    {
        return view('components.admin.trainings.index');
    }
}
