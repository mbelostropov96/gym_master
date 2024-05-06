<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\StoreReservationRequest;
use App\Services\ReservationService;
use App\Services\ClientTrainings\AbstractClientTraining;
use App\Services\ClientTrainings\ClientTrainingFactory;
use App\View\Components\Reservations\ClientReservations;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ReservationClientController
{
    public function __construct(
        private readonly ReservationService $reservationService,
    ) {
    }

    /**
     * @return Renderable
     * @throws Exception
     */
    public function index(): Renderable
    {
        $trainings = (new ClientTrainingFactory())->create(AbstractClientTraining::RESERVED)->index();

        $trainingsListComponent = new ClientReservations($trainings);

        return $trainingsListComponent->render()->with($trainingsListComponent->data());
    }

    /**
     * @return Renderable
     * @throws Exception
     */
    public function history(): Renderable
    {
        $trainings = (new ClientTrainingFactory())->create(AbstractClientTraining::HISTORY)->index();

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
