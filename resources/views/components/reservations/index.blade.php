@php use App\Services\ClientTrainings\AbstractClientTraining; @endphp
@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <x-common::button :ref="route('profile')" :label="__('gym.back_to_profile')" />
            <x-common::card :headerName="$trainingType === AbstractClientTraining::HISTORY
                ? __('gym.training_history')
                : __('gym.your_reservations')">
                <x-slot:body>
                    <x-common::table :columnsName="$columnsName" :columns="$columns" :contents="$reservedTrainings" :clickableRouteWithId="$clickableRouteWithId" />
                </x-slot:body>
            </x-common::card>
        </x-slot:content>
    </x-common::justify-container>
@endsection
