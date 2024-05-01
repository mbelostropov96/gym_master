<?php

namespace App\Http\Controllers\Client;

use App\Enums\TrainingType;
use App\Models\ClientInfo;
use App\Models\Reservation;
use App\Models\Training;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class TrainingClientController
{
    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        $trainings = (new Training())->newQuery()
            ->with([
                'clients',
                'instructor',
            ])
            ->get();

        $trainings = $trainings->filter(static function (Training $training) {
            if (
                $training->type === TrainingType::SINGLE->value
                && $training->clients->isNotEmpty()
            ) {
                return false;
            }

            return true;
        });

        return view('');
    }

    /**
     * @return Renderable
     */
    public function reservations(): Renderable
    {
        $trainings = (new Training())->newQuery()
            ->with([
                'instructor',
            ])
            ->where('reservations.client_id', '=', auth()->user()->id)
            ->join(Reservation::TABLE, static function (JoinClause $join) {
                $join->on(
                    sprintf('%s.training_id',Reservation::TABLE),
                    '=',
                    sprintf('%s.id',Training::TABLE)
                );
            })
            ->get();

        return view('');
    }

    /**
     * @param int $trainingId
     * @return Renderable
     */
    public function reserve(int $trainingId): Renderable
    {
        DB::beginTransaction();
        try {
            /** @var Training $training */
            $training = (new Training())->newQuery()
                ->with([
                    'clients'
                ])
                ->findOrFail($trainingId);

            if (
                $training->type === TrainingType::SINGLE->value
                && $training->clients->isNotEmpty()
            ) {
                throw new \RuntimeException('snovaa loh', 200);
            }

            /** @var ClientInfo $clientInfo */
            $clientInfo = (new ClientInfo())->newQuery()
                ->where('client_id', '=', auth()->user()->id)
                ->first();

            if ($clientInfo->balance < $training->price) {
                throw new \RuntimeException('snovaa loh', 200);
            }

            $clientInfo->balance = $clientInfo->balance - $training->price;
            $clientInfo->save();

            (new Reservation())->newQuery()
                ->create([
                    'training_id' => $trainingId,
                    'client_id' => $clientInfo->id,
                ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            dd($e->getMessage());
        }

        return view('');
    }
}
