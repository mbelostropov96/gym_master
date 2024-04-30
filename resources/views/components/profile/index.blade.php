@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <x-profile::general-info/>
            <x-profile::users/>
            <x-profile::training-templates/>
        </x-slot:content>
    </x-common::justify-container>
@endsection
