@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('gym.admin.users.header') }}</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">{{ __('gym.last_name') }}</th>
                                    <th scope="col">{{ __('gym.first_name') }}</th>
                                    <th scope="col">{{ __('gym.middle_name') }}</th>
                                    <th scope="col"> {{ __('gym.email') }} </th>
                                    <th scope="col"> {{ __('gym.role') }} </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr class='clickable-row' data-href='{{ route('users.update', ['id' => $user->id]) }}'>
                                    <th>{{ $user->id }}</a></th>
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->middle_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ __('gym.' . $user->role) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
