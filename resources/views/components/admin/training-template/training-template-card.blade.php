@php use App\Enums\TrainingType; @endphp
@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <x-common::button :ref="route('admin.training-templates.index')" :label="__('gym.back_to_list')"/>
            <x-common::card :headerName="__('gym.training-template-card')">
                <x-slot:body>
                    <x-common::form
                        :method="'PATCH'"
                        :action="route('admin.training-templates.update', ['id' => $trainingTemplate->id])"
                        :buttonLabel="__('gym.save')"
                    >
                        <x-slot:content>
                            <x-common::input
                                :label="__('gym.training_template_name')"
                                :name="'name'"
                                :value="$trainingTemplate->name"
                            />
                            <x-common::select
                                :label="__('gym.training_template_type')"
                                :name="'type'"
                                :values="array_column(TrainingType::cases(), 'value')"
                                :current-value="$trainingTemplate->type"
                            />
                            <x-common::textarea
                                :label="__('gym.training_template_description')"
                                :name="'description'"
                                :value="$trainingTemplate->description"
                            />
                            <x-common::input
                                :label="__('gym.training_template_price')"
                                :name="'price'"
                                :value="$trainingTemplate->price"
                                :type="'number'"
                            />
                            <x-common::input
                                :label="__('gym.training_template_energy_consumption')"
                                :name="'energy_consumption'"
                                :value="$trainingTemplate->energy_consumption"
                            />
                            <x-common::input
                                :label="__('gym.training_template_max_clients')"
                                :name="'max_clients'"
                                :value="$trainingTemplate->max_clients"
                                :type="'number'"
                            />
                            <x-common::input
                                :label="__('gym.training_template_duration')"
                                :name="'duration'"
                                :value="$trainingTemplate->duration"
                                :type="'number'"
                            />
                        </x-slot:content>
                    </x-common:form>
                    <form method='POST' action="{{ route('admin.training-templates.destroy', ['id' => $trainingTemplate->id]) }}">
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
