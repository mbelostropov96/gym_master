<?php

namespace App\View\Components\Admin\Training;

use App\Models\Training as TrainingModel;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Training extends Component
{
    public array $instructorsMap;
    public string $trainerName = '';

    public function __construct(
        public readonly TrainingModel $training,
        public readonly Collection $instructors,
    ) {}

    public function render(): View|Closure|string
    {
        $this->instructorsMap = [];
        $keyedInstructors = $this->instructors->keyBy('id');
        $keyedInstructors->map(
            fn (\App\Models\User $instructor) => $this->instructorsMap[$instructor->id] = $instructor->getFullName()
        );

        return view('components.admin.training.training-card');
    }
}
