@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <x-common::button :ref="route('training-templates.index')" :label="__('gym.back_to_list')"/>
            <x-common::card :headerName="__('gym.training-template-card')">
                <x-slot:body>
                    <x-common::form
                        :method="'PATCH'"
                        :action="route('training-templates.update', ['id' => $trainingTemplate->id])"
                        :buttonLabel="__('gym.save')"
                    >
                        <x-slot:content>
                            <x-common::input
                                :label="__('gym.training_template_name')"
                                :name="'name'"
                                :value="$trainingTemplate->name"
                            />
                            <x-admin::select-training-type :currentTrainingType="$trainingTemplate->type"/>
                            <x-common::input
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
                                :label="__('gym.training_template_duration')"
                                :name="'duration'"
                                :value="$trainingTemplate->duration"
                                :type="'number'"
                            />
                        </x-slot:content>
                    </x-common:form>
                    <form method='POST' action="{{ route('training-templates.destroy', ['id' => $trainingTemplate->id]) }}">
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
