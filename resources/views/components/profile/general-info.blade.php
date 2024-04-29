<x-common::card :header-name="__('gym.dashboard')">
    <x-slot:body>
        {{
            __('gym.dashboard_hello', [
                'name' => Auth::user()->first_name,
                'role' => __('gym.' . Auth::user()->role),
            ])
        }}
    </x-slot:body>
</x-common::card>
