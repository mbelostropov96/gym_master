@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <div class="d-flex justify-content-between">
                <div class="p-1">
                    <x-common::button :ref="route('profile')" :label="__('gym.back_to_profile')" />
                </div>
                <div class="p-2">
                    <x-common::button :ref="route('admin.tariffs.create')" :label="__('gym.create_tariff')" />
                </div>
            </div>
            <x-common::card :headerName="__('gym.tariffs')">
                <x-slot:body>
                    <x-common::table :columnsName="$columnsName" :columns="$columns" :contents="$tariffs" :clickableRouteWithId="$clickableRouteWithId" />
                </x-slot:body>
            </x-common::card>
        </x-slot:content>
    </x-common::justify-container>
@endsection
