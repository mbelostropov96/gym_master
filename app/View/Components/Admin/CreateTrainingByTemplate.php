<?php

namespace App\View\Components\Admin;

use App\Enums\UserRole;
use App\Models\TrainingTemplate;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class CreateTrainingByTemplate extends Component
{
    public string $currentTrainerName = '';
    public array $instructorsMap;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public TrainingTemplate $trainingTemplate,
        public Collection $instructors,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $currentUserId = Auth::id();

        $this->instructorsMap = [];
        $keyedInstructors = $this->instructors->keyBy('id');
        $keyedInstructors->map(
            fn (\App\Models\User $instructor) => $this->instructorsMap[$instructor->id] = $instructor->getFullName()
        );
        if (Auth::user()->role === UserRole::INSTRUCTOR->value) {
            /** @var \App\Models\User $currentInstructor */
            $currentInstructor = $keyedInstructors->get($currentUserId);
            if ($currentInstructor !== null) {
                 $this->currentTrainerName = $currentInstructor->getFullName();
            }
        }

        return view('components.admin.create-training-by-template');
    }

    public function isInstructor() : bool
    {
        return Auth::user()->role === UserRole::INSTRUCTOR->value;
    }
}
