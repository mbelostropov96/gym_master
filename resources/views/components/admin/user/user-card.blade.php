@php use App\Enums\UserRole @endphp
<x-common::card :headerName="__('gym.user.card')">
    <x-slot:body>
        <x-common::form :method="'PATCH'" :action="route('admin.users.update', ['id' => $user->id])" :buttonLabel="__('gym.save')">
            <x-slot:content>
                <x-common::input :label="__('gym.last_name')" :value="$user->last_name" :name="'last_name'" />
                <x-common::input :label="__('gym.first_name')" :value="$user->first_name" :name="'first_name'" />
                <x-common::input :label="__('gym.middle_name')" :value="$user->middle_name" :name="'middle_name'" />
                <x-common::input :label="__('gym.email')" :value="$user->email" :name="'email'" />
                <x-common::select :label="__('gym.role')" :name="'role'" :values="array_column(UserRole::cases(), 'value')" :current-value="$user->role" />
            </x-slot:content>
            </x-common:form>
    </x-slot:body>
</x-common::card>
