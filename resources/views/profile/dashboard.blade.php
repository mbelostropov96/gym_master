@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('gym.dashboard') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        {{ __('gym.dashboard_hello', [
                            'name' => Auth::user()->first_name,
                            'role' => Auth::user()->role,
                        ])  }}
                    </div>
                </div>
                @if (Auth::user()->role === 'admin')
                    @include('profile.dashboard.users')
                @endif
            </div>
        </div>
    </div>
@endsection
