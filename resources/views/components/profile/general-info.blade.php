@php
    use App\Enums\Gender;
    use App\Enums\UserRole;
    use App\Models\ClientInfo;
    use Illuminate\Support\Facades\Auth;
    /** @var ClientInfo $clientInfo */
    $clientInfo = Auth::user()->clientInfo;
@endphp
<x-common::card :header-name="__('gym.dashboard')">
    <x-slot:body>
        <div class="row justify-content-center">
            <div class="col-md-5 col-sm-12">
                <h5>{{ __('gym.register_data') }}</h5>
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
            @if (Auth::user()->role === UserRole::CLIENT->value)
                <div class="col-md-5 col-sm-12">
                    <h5>{{ __('gym.your_parameters') }}</h5>
                    <x-common::form :method="'PATCH'" :action="route('users.client-info.update')" :buttonLabel="__('gym.save')">
                        <x-slot:content>
                            <x-common::select :label="__('gym.gender')" :name="'gender'" :values="array_column(Gender::cases(), 'value')" :current-value="$clientInfo->gender" />
                            <x-common::input :label="__('gym.age')" :type="'number'" :name="'age'"
                                :value="$clientInfo->age" />
                            <x-common::input :label="__('gym.height')" :name="'height'" :value="$clientInfo->height" />
                            <x-common::input :label="__('gym.weight')" :name="'weight'" :value="$clientInfo->weight" />
                        </x-slot:content>
                    </x-common::form>
                </div>
            @endif
            <div class="col-md-2 col-sm-12">
                {{ $buttons }}
            </div>
        </div>
    </x-slot:body>
</x-common::card>
