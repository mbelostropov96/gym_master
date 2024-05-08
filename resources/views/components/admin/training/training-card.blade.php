@php
    use App\Enums\TrainingType;
    use App\Enums\UserRole;
@endphp
@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <div class="d-flex justify-content-between">
                <div class="p-1">
                    <x-common::button :ref="route('admin.trainings.index')" :label="__('gym.back_to_trainings')" />
                </div>
                <div class="p-1">
                    <form method='POST' action="{{ route('admin.trainings.destroy', ['id' => $training->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit"> {{ __('gym.delete') }} </button>
                    </form>
                </div>
            </div>
            <x-common::card :headerName="__('gym.training')">
                <x-slot:body>
                    <x-common::form :method="'PATCH'" :action="route('admin.trainings.update', ['id' => $training->id])" :buttonLabel="__('gym.save')">
                        <x-slot:content>
                            <x-common::input :label="__('gym.training_name')" :name="'name'" :value="$training->name" />
                            <x-common::select :label="__('gym.instructor_name')" :name="'instructor_id'" :values="$instructorsMap" :current-value="$training->instructor->getFullName()"
                                :isDisabled="Auth::user()->role !== UserRole::ADMIN->value" :useValueId="true" />
                            <x-common::select :label="__('gym.training_template_type')" :name="'type'" :values="array_column(TrainingType::cases(), 'value')" :current-value="$training->type"
                                :isDisabled="true" />
                            <x-common::textarea :label="__('gym.training_description')" :name="'description'" :value="$training->description" />
                            <x-common::input :label="__('gym.training_price')" :name="'price'" :isDisabled="true" :value="$training->price" />
                            <x-common::input :label="__('gym.training_energy_consumption')" :name="'energy_consumption'" :value="$training->energy_consumption" />
                            <x-common::input :label="__('gym.training_max_clients')" :name="'max_clients'" :isDisabled="true" :value="$training->max_clients" />
                            <x-common::input :label="__('gym.training_start')" :name="'datetime_start'" :type="'datetime-local'" :value="$training->datetime_start" />
                            <x-common::input :label="__('gym.training_end')" :name="'datetime_end'" :type="'datetime-local'" :value="$training->datetime_end" />
                        </x-slot:content>
                    </x-common::form>
                </x-slot:body>
            </x-common::card>
            <x-admin::training.training-users-reservations :training="$training" />
        </x-slot:content>
    </x-common::justify-container>
@endsection
