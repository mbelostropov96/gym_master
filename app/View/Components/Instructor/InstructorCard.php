<?php

namespace App\View\Components\Instructor;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InstructorCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public readonly User $instructor,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.instructor.instructor-card');
    }
}
