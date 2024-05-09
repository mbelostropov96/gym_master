@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <x-profile::general-info :$tariffs>
                <x-slot:buttons>
                    <x-profile::users />
                    <x-profile::training-templates />
                    <x-profile::trainings />
                    <x-profile::client-trainings />
                    <x-profile::reservations />
                    <x-profile::training-history />
                    <x-profile::tariffs />
                </x-slot:buttons>
            </x-profile::general-info>
            <x-profile::user-statistics :$historyTrainings />
        </x-slot:content>
    </x-common::justify-container>
@endsection
