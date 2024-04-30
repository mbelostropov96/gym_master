@extends('layouts.app')
@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <x-common::button :ref="route('users.index')" :label="__('gym.back_to_list')"/>
            <x-admin::user-card :user="$user" />
            <x-admin::user-balance :user="$user" />
            <x-admin::user-balance-history :user="$user" />
        </x-slot:content>
    </x-common::justify-container>
@endsection
