<?php

namespace App\View\Components\Profile;

use App\Enums\UserRole;
use App\Helpers\DailyEnergyConsumptionCalculator;
use App\Models\ClientInfo;
use App\Models\Training;
use Closure;
use DateInterval;
use DatePeriod;
use DateTime;
use DateTimeZone;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class UserStatistics extends Component
{
    public string $chartData;

    public int $dailyEnergyConsumption = 2000;
    public function __construct(
        public readonly Collection $historyTrainings,
    ) {
    }

    public function render(): View|Closure|string
    {
        /** @var ClientInfo $clientInfo */
        $clientInfo = Auth::user()?->clientInfo;
        if ($clientInfo !== null) {
            $this->dailyEnergyConsumption = DailyEnergyConsumptionCalculator::calculate(
                $clientInfo->gender,
                $clientInfo->weight,
                $clientInfo->height,
                $clientInfo->age,
            );
        }

        $this->prepareChartData();

        return view('components.profile.user-statistics');
    }

    public function shouldRender(): bool
    {
        return Auth::user()->role === UserRole::CLIENT->value;
    }

    private function prepareChartData(): void
    {
        $periodStart = new DateTime('last month');
        $periodEnd = new DateTime('tomorrow');
        $dateInterval = new DateInterval('P1D');
        $period = new DatePeriod($periodStart, $dateInterval, $periodEnd);

        $trainings = $this->historyTrainings->keyBy('datetime_start')->filter(
            static function (Training $training) use ($periodStart) {
                return $training->datetime_start > $periodStart->format('Y-m-d\TH:i');
            }
        )->sortBy('datetime_start');

        $data = [];
        foreach ($period as $day) {
            $dayFormat = $day->format('Y-m-d');
            $dayData['date'] = $day->format('d.m.Y');
            $dayData['consumption'] = 0;
            $data[$dayFormat] = $dayData;
        }

        foreach ($trainings as $training) {
            $trainingDate = DateTime::createFromFormat(
                'Y-m-d H:i:s',
                $training->datetime_start,
                new DateTimeZone(date_default_timezone_get())
            )->format('Y-m-d');
            if (isset($data[$trainingDate])) {
                $data[$trainingDate]['consumption'] += $training->energy_consumption;
            }
        }

        $this->chartData = json_encode($data);
    }
}
