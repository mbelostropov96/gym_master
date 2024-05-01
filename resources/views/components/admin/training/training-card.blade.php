@php use App\Enums\TrainingType;use App\Enums\UserRole; @endphp
@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <x-common::button :ref="route('trainings.index')" :label="__('gym.back_to_trainings')"/>
            <x-common::card :headerName="__('gym.training')">
                <x-slot:body>
                    <x-common::form
                        :method="'PATCH'"
                        :action="route('trainings.update', ['id' => $training->id])"
                        :buttonLabel="__('gym.save')"
                    >
                        <x-slot:content>
                            <x-common::input
                                :label="__('gym.training_name')"
                                :name="'name'"
                                :value="$training->name"
                            />
                            <x-common::select
                                :label="__('gym.instructor_name')"
                                :name="'instructor_id'"
                                :values="$instructorsMap"
                                :current-value="$training->instructor->getFullName()"
                                :isDisabled="Auth::user()->role !== UserRole::ADMIN->value"
                                :useValueId="true"
                            />
                            <x-common::select
                                :label="__('gym.training_template_type')"
                                :name="'type'"
                                :values="array_column(TrainingType::cases(), 'value')"
                                :current-value="$training->type"
                                :isDisabled="true"
                            />
                            <x-common::textarea
                                :label="__('gym.training_description')"
                                :name="'description'"
                                :value="$training->description"
                            />
                            <x-common::input
                                :label="__('gym.training_price')"
                                :name="'price'"
                                :isDisabled="true"
                                :value="$training->price"
                            />
                            <x-common::input
                                :label="__('gym.training_start')"
                                :name="'datetime_start'"
                                :type="'datetime-local'"
                                :value="$training->datetime_start"
                            />
                            <x-common::input
                                :label="__('gym.training_end')"
                                :name="'datetime_end'"
                                :type="'datetime-local'"
                                :value="$training->datetime_end"
                            />
                        </x-slot:content>
                    </x-common::form>
                    <form method='POST' action="{{ route('trainings.destroy', ['id' => $training->id]) }}">
                        @csrf
                        @method('DELETE')
                        <div class="col-md-8 offset-md-4">
                            <button class="btn btn-danger" type="submit"> {{ __('gym.delete') }} </button>
                        </div>
                    </form>
                </x-slot:body>
            </x-common::card>
        </x-slot:content>
    </x-common::justify-container>
@endsection
