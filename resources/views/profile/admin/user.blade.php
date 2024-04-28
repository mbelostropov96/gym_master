@php use App\Enums\UserRole; @endphp
@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('users.index') }}">
            <button class="btn btn-primary"> {{ __('gym.back_to_list') }} </button>
        </a>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('gym.user.card') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('users.update', ['id' => $user->id])  }}">
                            @csrf
                            @method('PATCH')
                            <div class="row mb-3">
                                <label for="last_name"
                                       class="col-md-4 col-form-label text-md-end">{{ __('gym.last_name')}}</label>
                                <div class="col-md-6">
                                    <input id="last_name" class="form-control" name="last_name" value="{{ $user->last_name }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="first_name"
                                       class="col-md-4 col-form-label text-md-end">{{ __('gym.first_name')}}</label>
                                <div class="col-md-6">
                                    <input id="first_name" class="form-control"  name="first_name" value="{{ $user->first_name }}" required
                                           >
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="middle_name"
                                       class="col-md-4 col-form-label text-md-end">{{ __('gym.middle_name')}}</label>
                                <div class="col-md-6">
                                    <input id="middle_name" class="form-control"  name="middle_name" value="{{ $user->middle_name }}" required
                                           >
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-end">{{ __('gym.email')}}</label>
                                <div class="col-md-6">
                                    <input id="email" class="form-control" type="email" name="email" value="{{ $user->email }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="last_name"
                                       class="col-md-4 col-form-label text-md-end">{{ __('gym.role')}}</label>
                                <div class="col-md-6">
                                    <select name="role" id="role" class="form-select">
                                        @foreach (UserRole::cases() as $role)
                                            <option value="{{ $role->value }}"
                                                @if ($user->role === $role->value)
                                                    selected
                                               @endif
                                            > {{ __('gym.' . $role->value) }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('gym.save') }}
                                </button>
                            </div>
                        </form>
                        <form method="POST" action="{{ route('users.destroy', ['id' => $user->id]) }}" >
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit"> {{ __('gym.delete') }} </button>
                        </form>
                    </div>
                </div>
                @if ($user->role === UserRole::CLIENT->value)
                    @include('profile.admin.user.balance')
                    @include('profile.admin.user.balance_history')
                @endif
            </div>
        </div>
    </div>
@endsection
