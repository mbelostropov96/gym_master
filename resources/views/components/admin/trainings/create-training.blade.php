@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <x-common::button :ref="route('trainings.index')" :label="__('gym.back_to_trainings')"/>
            <x-common::card :headerName="__('gym.choose_template_to_create_training')">
                <x-slot:body>
                    <x-common::table
                        :columnsName="$columnsName"
                        :columns="$columns"
                        :contents="$trainingTemplates"
                        :clickableRouteWithId="$clickableRouteWithId"
                    />
                </x-slot:body>
            </x-common::card>
        </x-slot:content>
    </x-common::justify-container>
@endsection
