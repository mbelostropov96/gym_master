@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <x-common::button :ref="route('profile')" :label="__('gym.back_to_profile')"/>
            <x-common::button :ref="route('training-template.create')" :label="__('gym.create_training_template')"/>
            <x-common::card :headerName="__('gym.training_templates')">
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
