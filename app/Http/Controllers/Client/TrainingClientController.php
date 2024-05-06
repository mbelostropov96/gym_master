<?php

namespace App\Http\Controllers\Client;

use App\Http\Builder\Filters\TrainingFilter;
use App\Http\Builder\Sorters\AbstractSorter;
use App\Http\Builder\Sorters\TrainingSorter;
use App\Models\Training;
use App\Services\TrainingService;
use App\View\Components\Trainings\ClientTrainings;
use App\View\Components\Trainings\TrainingCard;
use Illuminate\Contracts\Support\Renderable;

class TrainingClientController
{
    public function __construct(
        private readonly TrainingService $trainingService,
    ) {
    }

    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        $relations = [
            'clients',
            'instructor',
        ];
        $trainingFilter = new TrainingFilter([
            TrainingFilter::LESS_DATETIME_START => date('Y-m-d H:i:s', time()),
        ]);
        $trainingSorter = new TrainingSorter([
            TrainingSorter::ORDER_BY_DATETIME_START => AbstractSorter::SORT_ASC,
        ]);

        $trainings = $this->trainingService->index($relations, $trainingFilter, $trainingSorter);

        $trainings = $trainings->filter(static function (Training $training) {
            if (
                $training->max_clients <= $training->clients->count()
                || $training->clients->contains('id', '=', auth()->user()->id)
            ) {
                return false;
            }

            return true;
        });

        $trainingsListComponent = new ClientTrainings($trainings);

        return $trainingsListComponent->render()->with($trainingsListComponent->data());
    }

    /**
     * @param int $id
     * @return Renderable
     */
    public function show(int $id): Renderable
    {
        $training = $this->trainingService->show($id, [
            'instructor',
            'clients',
            'reservations',
        ]);

        $trainingComponent = new TrainingCard(
            $training,
        );

        return $trainingComponent->render()->with($trainingComponent->data());
    }
}
