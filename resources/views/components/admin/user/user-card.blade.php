<x-common::card :headerName="__('gym.user.card')">
    <x-slot:body>
        <x-common::form
            :method="'PATCH'"
            :action="route('users.update', ['id' => $user->id])"
            :buttonLabel="__('gym.save')"
        >
           <x-slot:content>
               <x-common::input
                   :label="__('gym.last_name')"
                   :value="$user->last_name"
                   :name="'last_name'"
               />
               <x-common::input
                   :label="__('gym.first_name')"
                   :value="$user->first_name"
                   :name="'first_name'"
               />
               <x-common::input
                   :label="__('gym.middle_name')"
                   :value="$user->middle_name"
                   :name="'middle_name'"
               />
               <x-common::input
                   :label="__('gym.email')"
                   :value="$user->email"
                   :name="'email'"
               />
               <x-admin::select-role :currentRole="$user->role"/>
           </x-slot:content>
        </x-common:form>
        <form method='POST' action="{{ route('users.destroy', ['id' => $user->id]) }}">
            @csrf
            @method('DELETE')
            <div class="col-md-8 offset-md-4">
                <button class="btn btn-danger" type="submit"> {{ __('gym.delete') }} </button>
            </div>
        </form>
    </x-slot:body>
</x-common::card>
