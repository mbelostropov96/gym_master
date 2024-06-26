@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <x-common::button :ref="route('profile')" :label="__('gym.back_to_profile')" />
            <x-common::card :headerName="__('gym.admin.users.header')">
                <x-slot:body>
                    <x-common::table :columnsName="$columnsName" :columns="$columns" :contents="$users" :clickableRouteWithId="$clickableRouteWithId" />
                </x-slot:body>
            </x-common::card>
        </x-slot:content>
    </x-common::justify-container>
@endsection
