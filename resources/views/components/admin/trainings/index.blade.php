@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <div class="d-flex justify-content-between">
                <div class="p-1">
                    <x-common::button :ref="route('profile')" :label="__('gym.back_to_profile')"/>
                </div>
                <div class="p-1">
                    <x-common::button :ref="route('admin.trainings.create')" :label="__('gym.create_training')"/>
                </div>
            </div>
            <x-common::card :headerName="__('gym.trainings')">
                <x-slot:body>
                    <x-common::table
                        :columnsName="$columnsName"
                        :columns="$columns"
                        :contents="$trainings"
                        :clickableRouteWithId="$clickableRouteWithId"
                    />
                </x-slot:body>
            </x-common::card>
        </x-slot:content>
    </x-common::justify-container>
@endsection
