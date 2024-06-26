<?php

namespace App\View\Components\Admin\TrainingTemplate;

use App\View\ComponentTraits\HasTableTrait;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class TrainingTemplates extends Component
{
    use HasTableTrait;

    public function __construct(
        public readonly Collection $trainingTemplates,
    ) {
        $this->prepareTableData(
            'admin.training-templates.update',
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

    public function render(): View|Closure|string
    {
        return view('components.admin.training-templates.index');
    }
}
