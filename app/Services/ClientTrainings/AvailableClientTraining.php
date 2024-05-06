<?php

namespace App\Services\ClientTrainings;

use App\Http\Builder\Filters\TrainingFilter;
use App\Http\Builder\Sorters\AbstractSorter;
use App\Http\Builder\Sorters\TrainingSorter;
use App\Services\TrainingService;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class AvailableClientTraining extends AbstractClientTraining
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function index(): Collection
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

        return (new TrainingService())->index($relations, $trainingFilter, $trainingSorter);
    }
}
