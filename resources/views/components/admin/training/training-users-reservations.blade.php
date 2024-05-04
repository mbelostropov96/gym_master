<x-common::card :headerName="__('gym.clients_reservations')">
    <x-slot:body>
        <x-common::table
            :columnsName="$columnsName"
            :columns="$columns"
            :contents="$users"
            :clickableRouteWithId="$clickableRouteWithId"
            :actions="$actions"
        />
    </x-slot:body>
</x-common::card>
