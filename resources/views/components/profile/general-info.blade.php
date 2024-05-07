@php use App\Enums\UserRole; @endphp
<x-common::card :header-name="__('gym.dashboard')">
    <x-slot:body>
        <div class="row justify-content-center">
            <div class="col-md-9 col-sm-12">
                <table class="table">
                    <tbody>
                        @foreach ($contents as $name => $value)
                            <tr>
                                <th class="text-end">{{ $name }}</th>
                                <td>
                                    {{ __('gym.' . $value) === 'gym.' . $value ? $value : __('gym.' . $value) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if (Auth::user()->role === UserRole::CLIENT->value)
                    <div class="container">
                        <x-common::button :ref="route('tariffs.index')" :label="__('gym.change_tariff')"></x-common::button>
                    </div>
                @endif
            </div>
            <div class="col-md-3 col-sm-12">
                {{ $buttons }}
            </div>
        </div>
    </x-slot:body>
</x-common::card>
