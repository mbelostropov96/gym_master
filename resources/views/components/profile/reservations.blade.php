<x-common::card :headerName="__('gym.your_reservations')">
    <x-slot:body>
        <x-common::button :ref="route('trainings.reservations')" :label="__('gym.list')" />
    </x-slot:body>
</x-common::card>
