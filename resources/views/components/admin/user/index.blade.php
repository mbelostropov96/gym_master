@extends('layouts.app')
@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <a href="{{ route('users.index') }}">
                <button class="btn btn-primary"> {{ __('gym.back_to_list') }} </button>
            </a>
            <x-admin::user-card :user="$user" />
            <x-admin::user-balance :user="$user" />
            <x-admin::user-balance-history :user="$user" />
        </x-slot:content>
    </x-common::justify-container>
@endsection
