@php use App\Enums\UserRole; @endphp
<x-common::card :header-name="__('gym.statistics')">
    <x-slot:body>
        <x-common::alert :type="'success'" :message="__('gym.your_daily_consumption', ['consumption' => $dailyEnergyConsumption])"></x-common::alert>
        <div>
            <canvas id="user-statistics-chart" data="{{ $chartData }}"
                energy-consumption="{{ $dailyEnergyConsumption }}"></canvas>
        </div>
    </x-slot:body>
</x-common::card>

<script></script>
