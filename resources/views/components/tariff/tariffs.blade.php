@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <div class="d-flex justify-content-between">
                <div class="p-1">
                    <x-common::button :ref="route('profile')" :label="__('gym.back_to_profile')" />
                </div>
            </div>
            <x-common::card :headerName="__('gym.tariffs')">
                <x-slot:body>
                    <x-common::alert :type="'primary'" :message="__('gym.your_trainings_count', ['count' => $currentTrainingsCount])" />
                    <x-common::table :columnsName="$columnsName" :columns="$columns" :contents="$tariffs" :clickableRouteWithId="$clickableRouteWithId" :$actions />
                </x-slot:body>
            </x-common::card>
        </x-slot:content>
    </x-common::justify-container>
@endsection
