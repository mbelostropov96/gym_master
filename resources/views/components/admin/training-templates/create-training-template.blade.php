@php use App\Enums\TrainingType; @endphp
@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <x-common::button :ref="route('admin.training-templates.index')" :label="__('gym.back_to_list')"/>
            <x-common::card :headerName="__('gym.create_training_template')">
                <x-slot:body>
                  <x-common::form
                        :method="'POST'"
                        :action="route('admin.training-templates.store')"
                        :buttonLabel="__('gym.create')"
                    >
                        <x-slot:content>
                            <x-common::input
                                :label="__('gym.training_template_name')"
                                :name="'name'"
                            />
                            <x-common::select
                                :label="__('gym.training_template_type')"
                                :name="'type'"
                                :values="array_column(TrainingType::cases(), 'value')"
                                :current-value="''"
                            />
                            <x-common::textarea
                                :label="__('gym.training_template_description')"
                                :name="'description'"
                                :value="'Стандартная тренировка'"
                            />
                            <x-common::input
                                :label="__('gym.training_template_price')"
                                :name="'price'"
                            />
                            <x-common::input
                                :label="__('gym.training_template_energy_consumption')"
                                :name="'energy_consumption'"
                                :type="'number'"
                                :value="1500"
                            />
                            <x-common::input
                                :label="__('gym.training_template_max_clients')"
                                :name="'max_clients'"
                                :type="'number'"
                                :value="1"
                            />
                            <x-common::input
                                :label="__('gym.training_template_duration')"
                                :name="'duration'"
                                :type="'number'"
                            />
                        </x-slot:content>
                    </x-common::form>
                </x-slot:body>
            </x-common::card>
        </x-slot:content>
    </x-common::justify-container>
@endsection
