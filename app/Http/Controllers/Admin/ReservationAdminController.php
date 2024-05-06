<?php

namespace App\Http\Controllers\Admin;

use App\Service\ReservationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class ReservationAdminController
{
    public function __construct(
        private readonly ReservationService $reservationService,
    ) {
    }

    /**
     * @param int $reservationId
     * @return RedirectResponse
     */
    public function destroy(int $reservationId): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $this->reservationService->destroy($reservationId);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
        }

        return redirect()->to(route('reservations.index'));
    }
}
