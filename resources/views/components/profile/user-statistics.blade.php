@php use App\Enums\UserRole; @endphp
<x-common::card :header-name="__('gym.statistics')">
    <x-slot:body>
        @if ($dailyEnergyConsumption !== 0)
            <x-common::alert :type="'success'" :message="__('gym.your_daily_consumption', ['consumption' => $dailyEnergyConsumption])"></x-common::alert>
        @else
            <x-common::alert :type="'warning'" :message="__('gym.fill_data_to_personification', ['consumption' => $dailyEnergyConsumption])"></x-common::alert>
        @endif
        <div>
            <canvas id="user-statistics-chart" data="{{ $chartData }}"
                energy-consumption="{{ $dailyEnergyConsumption }}"></canvas>
        </div>
    </x-slot:body>
</x-common::card>

<script></script>
