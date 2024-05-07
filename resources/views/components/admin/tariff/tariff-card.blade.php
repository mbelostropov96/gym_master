@extends('layouts.app')

@section('content')
    <x-common::justify-container>
        <x-slot:content>
            <x-common::button :ref="route('admin.tariffs.index')" :label="__('gym.back_to_list')" />
            <x-common::card :headerName="__('gym.training-template-card')">
                <x-slot:body>
                    <x-common::form :method="'PATCH'" :action="route('admin.tariffs.update', ['id' => $tariff->id])" :buttonLabel="__('gym.save')">
                        <x-slot:content>
                            <x-common::input :label="__('gym.tariff_name')" :name="'name'" :value="$tariff->name" />
                            <x-common::input :label="__('gym.tariff_discount')" :name="'discount'" :type="'number'" min="1"
                                max="100" :value="$tariff->discount" />
                            <x-common::input :label="__('gym.min_tariff_number_of_trainings')" :name="'number_of_trainings'" :type="'number'" :value="$tariff->number_of_trainings" />
                        </x-slot:content>
                    </x-common::form>
                    <form method='POST' action="{{ route('admin.tariffs.destroy', ['id' => $tariff->id]) }}">
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
