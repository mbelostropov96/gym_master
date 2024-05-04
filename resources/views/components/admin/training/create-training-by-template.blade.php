@php use App\Enums\TrainingType; @endphp
@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <x-common::button :ref="route('admin.trainings.create')" :label="__('gym.back_to_templates')"/>
            <x-common::card :headerName="__('gym.create_training')">
                <x-slot:body>
                    <x-common::form
                        :method="'POST'"
                        :action="route('admin.trainings.store')"
                        :buttonLabel="__('gym.create')"
                    >
                        <x-slot:content>
                            <x-common::input
                                :label="__('gym.training_name')"
                                :name="'name'"
                                :value="$trainingTemplate->name"
                            />
                            <x-common::select
                                :label="__('gym.instructor_name')"
                                :name="'instructor_id'"
                                :values="$instructorsMap"
                                :current-value="$isInstructor() ? $currentTrainerName : ''"
                                :isDisabled="$isInstructor()"
                                :useValueId="true"
                            />
                            <x-common::select
                                :label="__('gym.training_template_type')"
                                :name="'type'"
                                :values="array_column(TrainingType::cases(), 'value')"
                                :current-value="$trainingTemplate->type"
                                :isDisabled="true"
                            />
                           <x-common::textarea
                               :label="__('gym.training_description')"
                               :name="'description'"
                               :value="$trainingTemplate->description"
                           />
                            <x-common::input
                                :label="__('gym.training_price')"
                                :name="'price'"
                                :isDisabled="true"
                                :value="$trainingTemplate->price"
                            />
                            <x-common::input
                                :label="__('gym.training_energy_consumption')"
                                :name="'energy_consumption'"
                                :isDisabled="true"
                                :value="$trainingTemplate->energy_consumption"
                            />
                            <x-common::input
                                :label="__('gym.training_max_clients')"
                                :name="'max_clients'"
                                :isDisabled="true"
                                :value="$trainingTemplate->max_clients"
                            />
                            <x-common::input
                                :label="__('gym.training_start')"
                                :name="'datetime_start'"
                                :type="'datetime-local'"
                            />
                            <input type="hidden" name="duration" value="{{ $trainingTemplate->duration }}"/>
                        </x-slot:content>
                    </x-common::form>
                </x-slot:body>
            </x-common::card>
        </x-slot:content>
    </x-common::justify-container>
@endsection
