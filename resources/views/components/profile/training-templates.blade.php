<x-common::card :headerName="__('gym.training_templates')">
    <x-slot:body>
        <x-common::button :ref="route('training-template.index')" :label="__('gym.list')" />
    </x-slot:body>
</x-common::card>