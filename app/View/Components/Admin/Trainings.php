<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Trainings extends Component
{
    public string $clickableRouteWithId;
    public array $columnsName;
    public array $columns;

    private array $attributeNameMap;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public readonly Collection $trainingTemplates,
    ) {
        $this->attributeNameMap = [
            'id' => 'ID',
            'name' => __('gym.training_template_name'),
            'type' => __('gym.training_template_type'),
            'price' => __('gym.training_price'),
            'start' => __('gym.training_start_date'),
        ];
        $this->clickableRouteWithId = 'training.update';
        $this->columnsName = $this->attributeNameMap;
        $this->columns = array_flip($this->attributeNameMap);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.trainings');
    }
}
