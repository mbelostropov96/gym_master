<?php

namespace App\Service;

use App\Models\Reservation;

class ReservationService
{
    /**
     * @param int $id
     * @param array|null $relations
     * @return Reservation
     */
    public function show(int $id, array $relations = null): Reservation
    {
        $builder = (new Reservation())->newQuery();

        if ($relations !== null) $builder->with($relations);

        /** @var Reservation $reservation */
        $reservation = $builder->findOrFail($id);

        return $reservation;
    }
}
