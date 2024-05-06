<?php

namespace App\Services\ClientTrainings;

use App\Http\Builder\Filters\TrainingFilter;
use App\Http\Builder\Sorters\AbstractSorter;
use App\Http\Builder\Sorters\TrainingSorter;
use App\Services\TrainingService;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class HistoryClientTraining extends AbstractClientTraining
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function index(): Collection
    {
        $relations = [
            'instructor',
            'ratings',
        ];
        $trainingFilter = new TrainingFilter(
            [
                TrainingFilter::CLIENT_ID => auth()->user()->id,
                TrainingFilter::MORE_DATETIME_START => (
                new DateTime(
                    timezone: new DateTimeZone(date_default_timezone_get())
                )
                )->format('Y-m-d\TH:i'),
            ]
        );
        $trainingSorter = new TrainingSorter([
            TrainingSorter::ORDER_BY_DATETIME_START => AbstractSorter::SORT_ASC,
        ]);

        return (new TrainingService())->index($relations, $trainingFilter, $trainingSorter);
    }
}
