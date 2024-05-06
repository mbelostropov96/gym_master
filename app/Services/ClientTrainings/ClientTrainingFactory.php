<?php

namespace App\Services\ClientTrainings;

class ClientTrainingFactory
{
    /**
     * @param string $type
     * @return AbstractClientTraining
     */
    public function create(string $type): AbstractClientTraining
    {
        return match ($type) {
            AbstractClientTraining::AVAILABLE => new AvailableClientTraining(),
            AbstractClientTraining::HISTORY => new HistoryClientTraining(),
            default => new ReservedClientTraining(),
        };
    }
}
