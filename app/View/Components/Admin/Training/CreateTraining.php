<?php

namespace App\View\Components\Admin\Training;

use App\Enums\UserRole;
use App\View\ComponentTraits\HasTableTrait;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class CreateTraining extends Component
{
    use HasTableTrait;

    public string $createTrainingRoute;
    public string $trainingListRoute;

    public function __construct(
        public Collection $trainingTemplates
    ) {
        $this->prepareRoutesByRole();
        $this->prepareTableData(
            $this->createTrainingRoute,
            [
                'id' => 'ID',
                'name' => __('gym.training_template_name'),
                'type' => __('gym.training_template_type'),
                'price' => __('gym.training_template_price'),
                'duration' => __('gym.training_template_duration'),
                'energy_consumption' => __('gym.calories_consumption'),
                'max_clients' => __('gym.max_participants'),
            ]
        );
    }

    private function prepareRoutesByRole(): void
    {
        $this->trainingListRoute = match (Auth::user()->role) {
            UserRole::ADMIN->value => 'admin.trainings.index',
            UserRole::INSTRUCTOR->value => 'instructor.trainings.index',
        };
        $this->createTrainingRoute = match (Auth::user()->role) {
            UserRole::ADMIN->value => 'admin.create-by-template.create',
            UserRole::INSTRUCTOR->value => 'instructor.create-by-template.create',
        };
    }

    public function render(): View|Closure|string
    {
        return view('components.admin.trainings.create-training');
    }
}
