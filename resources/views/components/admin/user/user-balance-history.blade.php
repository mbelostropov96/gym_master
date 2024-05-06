<x-common::card :headerName="__('gym.user.balance_history')">
    <x-slot:body>
        <x-common::table :columnsName="[
            __('gym.operation_id'),
            __('gym.operation_created_at'),
            __('gym.old_balance'),
            __('gym.balance_change_amount'),
            __('gym.operation_description'),
        ]" :columns="['id', 'created_at', 'old_balance', 'balance_change', 'description']" :contents="$user->balanceEvents" />
    </x-slot:body>
</x-common::card>
