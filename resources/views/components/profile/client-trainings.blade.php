<x-common::card :headerName="__('gym.available_trainings')">
    <x-slot:body>
        <x-common::button :ref="route('trainings.index')" :label="__('gym.list')" />
    </x-slot:body>
</x-common::card>
