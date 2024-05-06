@php use App\Enums\TrainingType; @endphp
@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <div class="d-flex justify-content-between">
                <div class="p-1">
                    <x-common::button :ref="route('profile')" :label="__('gym.back_to_profile')" />
                </div>
                @if ($training->clients->where('id', '=', Auth::user()->id)->isEmpty())
                    <div class="p-2">
                        <x-common::button :ref="route('reservations.store')" :label="__('gym.reserve')" :post="true" :postParams="['training_id' => $training->id]" />
                    </div>
                @elseif (
                    $training->datetime_start >
                        (new DateTime(timezone: new DateTimeZone(date_default_timezone_get())))->format('Y-m-d\TH:i'))
                    <div class="p-2">
                        <form method="POST"
                            action="{{ route('reservations.destroy', [
                                'id' => $training->reservations->where('client_id', '=', Auth::user()->id)->first()->id,
                            ]) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit"> {{ __('gym.cancel_reservation') }} </button>
                        </form>
                    </div>
                @else
                    <form id="rating-form" method="POST" action="{{ route('trainings.rating') }}">
                        @csrf
                        <div class="p-1">
                            <input id="rating" class="rating form-control" name="rating" hidden
                                value="{{ $training->ratings->where('client_id', '=', Auth::User()->id)?->first()?->rating ?? 10 }}"
                                min="1" max="10" step="1" type="number">
                            <input type="hidden" name="training_id" value="{{ $training->id }}" />
                        </div>
                        <button class="btn btn-primary" type="submit" hidden> {{ __('gym.set_rating') }} </button>
                    </form>
                @endif
            </div>
            <x-common::card :headerName="__('gym.training')">
                <x-slot:body>
                    <x-common::form :method="'PATCH'" :action="''" :buttonLabel="''" :no-action="true">
                        <x-slot:content>
                            <x-common::input :label="__('gym.training_name')" :name="'name'" :isDisabled="true" :value="$training->name" />
                            <x-common::select :label="__('gym.instructor_name')" :name="'instructor_id'" :values="[$training->instructor->id => $training->instructor->getFullName()]" :current-value="$training->instructor->getFullName()"
                                :isDisabled="true" :useValueId="true" />
                            <x-common::select :label="__('gym.training_template_type')" :name="'type'" :values="array_column(TrainingType::cases(), 'value')" :current-value="$training->type"
                                :isDisabled="true" />
                            <x-common::textarea :label="__('gym.training_description')" :name="'description'" :value="$training->description"
                                :isDisabled="true" />
                            <x-common::input :label="__('gym.training_price')" :name="'price'" :isDisabled="true" :value="$training->price" />
                            <x-common::input :label="__('gym.training_start')" :name="'datetime_start'" :type="'datetime-local'" :value="$training->datetime_start"
                                :isDisabled="true" />
                            <x-common::input :label="__('gym.training_end')" :name="'datetime_end'" :type="'datetime-local'" :value="$training->datetime_end"
                                :isDisabled="true" />
                        </x-slot:content>
                    </x-common::form>
                </x-slot:body>
            </x-common::card>
        </x-slot:content>
    </x-common::justify-container>
    <script>
        $('#rating').rating({
            showCaption: false,
            clearButton: '',
            stars: 10
        }).on('rating:change', function(event, value, caption) {
            $('#rating-form').submit();
        });
    </script>
@endsection
