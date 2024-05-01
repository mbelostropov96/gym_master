@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <x-common::button :ref="route('profile')" :label="__('gym.back_to_profile')"/>
            <x-common::button :ref="route('trainings.create')" :label="__('gym.create_training')"/>
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
