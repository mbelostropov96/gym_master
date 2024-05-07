@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <x-profile::general-info :$tariffs>
                <x-slot:buttons>
                    <div class="row">
                        <x-profile::users />
                    </div>
                    <div class="row">
                        <x-profile::training-templates />
                    </div>
                    <div class="row">
                        <x-profile::trainings />
                    </div>
                    <div class="row">
                        <x-profile::client-trainings />
                    </div>
                    <div class="row">
                        <x-profile::reservations />
                    </div>
                    <div class="row">
                        <x-profile::training-history />
                    </div>
                    <div class="row">
                        <x-profile::tariffs />
                    </div>
                </x-slot:buttons>
            </x-profile::general-info>
        </x-slot:content>
    </x-common::justify-container>
@endsection
