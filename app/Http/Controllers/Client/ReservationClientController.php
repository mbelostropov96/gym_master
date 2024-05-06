<?php

namespace App\Http\Controllers\Client;

use App\Http\Builder\Filters\TrainingFilter;
use App\Http\Builder\Sorters\AbstractSorter;
use App\Http\Builder\Sorters\TrainingSorter;
use App\Http\Requests\StoreReservationRequest;
use App\Service\ReservationService;
use App\Service\TrainingService;
use App\View\Components\Reservations\ClientReservations;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ReservationClientController
{
    public function __construct(
        private readonly TrainingService $trainingService,
        private readonly ReservationService $reservationService,
    ) {
    }

    /**
     * @return Renderable
     * @throws Exception
     */
    public function index(): Renderable
    {
        $relations = [
            'instructor',
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

        $trainings = $this->trainingService->index($relations, $trainingFilter, $trainingSorter);

        $trainingsListComponent = new ClientReservations($trainings);

        return $trainingsListComponent->render()->with($trainingsListComponent->data());
    }

    /**
     * @param StoreReservationRequest $request
     * @return RedirectResponse
     */
    public function store(StoreReservationRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $trainingId = $data['training_id'];

        DB::transaction(
            fn() => $this->reservationService->store($trainingId)
        );

        return redirect()->to(route('reservations.index'));
    }

    /**
     * @param int $reservationId
     * @return RedirectResponse
     */
    public function destroy(int $reservationId): RedirectResponse
    {
        DB::transaction(
            fn() => $this->reservationService->destroy($reservationId)
        );

        return redirect()->to(route('reservations.index'));
    }
}
