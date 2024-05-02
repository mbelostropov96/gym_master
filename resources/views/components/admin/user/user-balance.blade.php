<x-common::card :headerName="__('gym.user.balance')">
    <x-slot:body>
        <x-common::form
            :method="'PATCH'"
            :action="route('users.balance.update', ['id' => $user->id])"
            :buttonLabel="__('gym.balance_top_up')"
        >
            <x-slot:content>
                <x-common::input
                    :label="__('gym.current_balance')"
                    :value="$user->clientInfo?->balance . ' ' .  __('gym.currency_symbol')"
                    :isDisabled="true"
                />
                <x-common::input
                    :id="'balance'"
                    :label="__('gym.apply_balance_amount')"
                    :name="'balance'"
                    :type="'number'"
                />
            </x-slot:content>
        </x-common::form>
    </x-slot:body>
</x-common::card>
