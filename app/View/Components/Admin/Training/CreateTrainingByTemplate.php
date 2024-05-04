<?php

namespace App\View\Components\Admin\Training;

use App\Enums\UserRole;
use App\Models\TrainingTemplate;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class CreateTrainingByTemplate extends Component
{
    public string $currentTrainerName = '';
    public array $instructorsMap;

    public function __construct(
        public TrainingTemplate $trainingTemplate,
        public Collection $instructors,
    ) {}

    public function render(): View|Closure|string
    {
        $currentUserId = Auth::id();

        $this->instructorsMap = [];
        $keyedInstructors = $this->instructors->keyBy('id');
        $keyedInstructors->map(
            fn (User $instructor) => $this->instructorsMap[$instructor->id] = $instructor->getFullName()
        );
        if (Auth::user()->role === UserRole::INSTRUCTOR->value) {
            /** @var User $currentInstructor */
            $currentInstructor = $keyedInstructors->get($currentUserId);
            if ($currentInstructor !== null) {
                 $this->currentTrainerName = $currentInstructor->getFullName();
            }
        }

        return view('components.admin.training.create-training-by-template');
    }

    public function isInstructor() : bool
    {
        return Auth::user()->role === UserRole::INSTRUCTOR->value;
    }
}
