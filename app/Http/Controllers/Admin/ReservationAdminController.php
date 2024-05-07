<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReservationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ReservationAdminController extends Controller
{
    public function __construct(
        private readonly ReservationService $reservationService,
    ) {
        parent::__construct();
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
