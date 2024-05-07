@php use App\Enums\TrainingType; @endphp
@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <x-common::button :ref="route('admin.tariffs.index')" :label="__('gym.back_to_list')" />
            <x-common::card :headerName="__('gym.create_tariff')">
                <x-slot:body>
                    <x-common::form :method="'POST'" :action="route('admin.tariffs.store')" :buttonLabel="__('gym.create')">
                        <x-slot:content>
                            <x-common::input :label="__('gym.tariff_name')" :name="'name'" :value="'Тариф Новый'" />
                            <x-common::input :label="__('gym.tariff_discount')" :name="'discount'" :type="'number'" min="1"
                                max="100" :value="5" />
                            <x-common::input :label="__('gym.min_tariff_number_of_trainings')" :name="'number_of_trainings'" :type="'number'" :value="1" />
                        </x-slot:content>
                    </x-common::form>
                </x-slot:body>
            </x-common::card>
        </x-slot:content>
    </x-common::justify-container>
@endsection
