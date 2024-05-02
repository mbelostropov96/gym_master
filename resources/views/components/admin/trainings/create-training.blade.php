@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <x-common::button :ref="route('admin.trainings.index')" :label="__('gym.back_to_trainings')"/>
            <x-common::card :headerName="__('gym.training_templates')">
                <x-slot:body>
                    <x-common::alert :type="'primary'" :message="__('gym.choose_template_to_create_training')"/>
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
