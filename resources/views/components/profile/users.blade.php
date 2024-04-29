<x-common::card :header-name="__('gym.dashboard.users.header')">
    <x-slot:body>
        <a href="{{ asset('admin/users') }}">
            <button type="button" class="btn btn-primary">
                {{ __('gym.dashboard.users_list') }}
            </button>
        </a>
    </x-slot:body>
</x-common::card>
