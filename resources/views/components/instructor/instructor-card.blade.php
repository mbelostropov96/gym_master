@php
    use App\Enums\UserRole;
    $isDisabled = true;
@endphp

<template xmlns:x-common="http://www.w3.org/1999/html">
    <img :src="imgUrl" />
</template>

@extends('layouts.app')
@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <a onclick="history.back();" class="btn btn-primary"> {{ __('gym.back') }} </a>
            <x-common::card :headerName="__('gym.instructor')">
                <x-slot:body>
                    <div class="row">
                        <div class="col-md-7">
                            <form>
                                <x-common::input :label="__('gym.last_name')" :value="$instructor->last_name" :$isDisabled />
                                <x-common::input :label="__('gym.first_name')" :value="$instructor->first_name" :$isDisabled />
                                <x-common::input :label="__('gym.middle_name')" :value="$instructor->middle_name" :$isDisabled />
                                <x-common::input :label="__('gym.instructor_qualification')" :value="$instructor->instructorInfo?->qualification" :$isDisabled />
                                <x-common::input :label="__('gym.instructor_experience')" :value="$instructor->instructorInfo?->experience" :$isDisabled />
                                <x-common::textarea :label="__('gym.about_instructor')" :value="$instructor->instructorInfo?->description" :$isDisabled />
                                <div class="row mb-3">
                                    <label for="rating" class="col-md-4 col-form-label text-md-end">
                                        {{ __('gym.average_rating') . ':' }}</label>
                                    <div class="col-md-6">
                                        <input id="instructor-rating" class="rating form-control" name="rating"
                                            value="{{ $instructor->ratings->avg('rating') }}" min="0" max="10"
                                            step="1" type="number">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="container-fluid body-content">
                                        @if (!empty($instructor->instructorInfo?->image))
                                            <img src="{{ asset('storage/' . $instructor->instructorInfo->image) }}"
                                                class="img-fluid" alt="{{ __('gym.photo') }}">
                                        @else
                                            <div class="profile-picture center-block"></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-slot:body>
            </x-common::card>
        </x-slot:content>
    </x-common::justify-container>
    <script>
        $('#instructor-rating').rating({
            displayOnly: true,
            stars: 10,
            starCaptions: function(val) {
                return '{{ number_format($instructor->ratings->avg('rating'), 2) }}';
            }
        }).on('rating:change', function(event, value, caption) {
            $('#rating-form').submit();
        });
    </script>
@endsection
