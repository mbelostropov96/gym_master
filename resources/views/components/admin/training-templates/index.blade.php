@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <div class="d-flex justify-content-between">
                <div class="p-1">
                    <x-common::button :ref="route('profile')" :label="__('gym.back_to_profile')" />
                </div>
                <div class="p-2">
                    <x-common::button :ref="route('admin.training-templates.create')" :label="__('gym.create_training_template')" />
                </div>
            </div>
            <x-common::card :headerName="__('gym.training_templates')">
                <x-slot:body>
                    <x-common::table :columnsName="$columnsName" :columns="$columns" :contents="$trainingTemplates" :clickableRouteWithId="$clickableRouteWithId" />
                </x-slot:body>
            </x-common::card>
        </x-slot:content>
    </x-common::justify-container>
@endsection
