@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <x-common::button :ref="route('training-templates.index')" :label="__('gym.back_to_list')"/>
            <x-common::card :headerName="__('gym.create_training_template')">
                <x-slot:body>
                  <x-common::form
                        :method="'POST'"
                        :action="route('training-templates.store')"
                        :buttonLabel="__('gym.create')"
                    >
                        <x-slot:content>
                            <x-common::input
                                :label="__('gym.training_template_name')"
                                :name="'name'"
                            />
                            <x-admin::select-training-type :currentTrainingType="''"/>
                            <x-common::input
                                :label="__('gym.training_template_description')"
                                :name="'description'"
                            />
                            <x-common::input
                                :label="__('gym.training_template_price')"
                                :name="'price'"
                            />
                            <x-common::input
                                :label="__('gym.training_template_duration')"
                                :name="'duration'"
                            />
                        </x-slot:content>
                    </x-common::form>
                </x-slot:body>
            </x-common::card>
        </x-slot:content>
    </x-common::justify-container>
@endsection
