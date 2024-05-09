<?php

namespace App\View\Components\Admin\Training;

use App\Enums\UserRole;
use App\Models\Training as TrainingModel;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Training extends Component
{
    public array $instructorsMap;

    public string $updateTrainingRoute;
    public string $trainingsRoute;
    public string $deleteTrainingRoute;

    public function __construct(
        public readonly TrainingModel $training,
        public readonly Collection $instructors,
    ) {
    }

    private function prepareRoutesByRole(): void
    {
        $this->trainingsRoute = match (Auth::user()->role) {
            UserRole::ADMIN->value => 'admin.trainings.index',
            UserRole::INSTRUCTOR->value => 'instructor.trainings.index',
        };
        $this->updateTrainingRoute = match (Auth::user()->role) {
            UserRole::ADMIN->value => 'admin.trainings.update',
            UserRole::INSTRUCTOR->value => 'instructor.trainings.update',
        };
        $this->deleteTrainingRoute = match (Auth::user()->role) {
            UserRole::ADMIN->value => 'admin.trainings.destroy',
            UserRole::INSTRUCTOR->value => 'instructor.trainings.destroy',
        };
    }

    public function render(): View|Closure|string
    {
        $this->prepareRoutesByRole();

        $this->instructorsMap = [];
        $keyedInstructors = $this->instructors->keyBy('id');
        $keyedInstructors->map(
            fn (User $instructor) => $this->instructorsMap[$instructor->id] = $instructor->getFullName()
        );

        return view('components.admin.training.training-card');
    }
}
