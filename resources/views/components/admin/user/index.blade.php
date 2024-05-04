@extends('layouts.app')
@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <div class="d-flex justify-content-between">
                <div class="p-1">
                    <x-common::button :ref="route('admin.users.index')" :label="__('gym.back_to_list')"/>
                </div>
                <div class="p-1">
                    <form method='POST' action="{{ route('users.destroy', ['id' => $user->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit"> {{ __('gym.delete_user') }} </button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <x-admin::user-card :user="$user"/>
                </div>
                <div class="col-md-6">
                    <x-admin::user-balance :user="$user"/>
                </div>
            </div>
            <x-admin::user-balance-history :user="$user"/>
        </x-slot:content>
    </x-common::justify-container>
@endsection
