<x-common::card :headerName="__('gym.trainings')">
    <x-slot:body>
        <x-common::button :ref="route('admin.trainings.index')" :label="__('gym.list')" />
    </x-slot:body>
</x-common::card>
