@php
    use App\Enums\Gender;
    use App\Enums\UserRole;
    use App\Models\InstructorInfo;
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;
    /** @var User $user */
    $user = Auth::user();
    $clientInfo = $user->clientInfo;
    $instructorInfo = $user->instructorInfo ?? new InstructorInfo();
@endphp
<x-common::card :header-name="__('gym.dashboard')" xmlns:x-common="http://www.w3.org/1999/html">
    <x-slot:body>
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-12">
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
                <x-common::form :method="'PATCH'" :action="route('users.update', ['id' => $user->id])" :buttonLabel="__('gym.save')">
                    <x-slot:content>
                        <x-common::input :label="__('gym.first_name')" :name="'first_name'" :value="$user->first_name" />
                        <x-common::input :label="__('gym.last_name')" :name="'last_name'" :value="$user->last_name" />
                        <x-common::input :label="__('gym.middle_name')" :name="'middle_name'" :value="$user->middle_name" />
                        <x-common::input :label="__('gym.email')" :name="'email'" :value="$user->email" />
                    </x-slot:content>
                </x-common::form>
            </div>
            @if (Auth::user()->role === UserRole::CLIENT->value)
                <div class="col-md-5 col-sm-12">
                    <h5>{{ __('gym.your_parameters') }}</h5>
                    <x-common::form :method="'PATCH'" :action="route('users.client-info.update')" :buttonLabel="__('gym.save')">
                        <x-slot:content>
                            <x-common::select :label="__('gym.gender')" :name="'gender'" :values="array_column(Gender::cases(), 'value')"
                                :current-value="$clientInfo->gender" />
                            <x-common::input :label="__('gym.age')" :type="'number'" :name="'age'"
                                :value="$clientInfo->age" />
                            <x-common::input :label="__('gym.height')" :name="'height'" :value="$clientInfo->height" />
                            <x-common::input :label="__('gym.weight')" :name="'weight'" :value="$clientInfo->weight" />
                        </x-slot:content>
                    </x-common::form>
                </div>
            @endif
            @if (Auth::user()->role === UserRole::INSTRUCTOR->value)
                <div class="col-md-5 col-sm-12">
                    <h5>{{ __('gym.your_data') }}</h5>
                    <x-common::form :method="'PATCH'" :action="route('users.instructor-info.update')" :buttonLabel="__('gym.save')" :encrypt="'multipart/form-data'">
                        <x-slot:content>
                            <x-common::input :label="__('gym.photo')" :type="'file'" :name="'image'" :isRequired="false"
                                :value="$instructorInfo->image" />
                            <x-common::textarea :label="__('gym.about_instructor')" :type="'description'" :name="'description'"
                                :isRequired="false" :value="$instructorInfo->description" />
                            <x-common::input :label="__('gym.instructor_experience')" :name="'experience'" :isRequired="false"
                                :value="$instructorInfo->experience" />
                            <x-common::textarea :label="__('gym.instructor_qualification')" :name="'qualification'" :isRequired="false"
                                :value="$instructorInfo->qualification" />
                        </x-slot:content>
                    </x-common::form>
                </div>
            @endif
            <div class="col-md-3 col-sm-12">
                @if (Auth::user()->role === UserRole::INSTRUCTOR->value)
                    <div class="card">
                        <div class="card-body">
                            <div class="container-fluid body-content">
                                @if (!empty($instructorInfo->image))
                                    <img src="{{ asset('storage/' . $instructorInfo->image) }}" class="img-fluid"
                                        alt="{{ __('gym.photo') }}">
                                @else
                                    <div class="profile-picture center-block"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                <div class="d-grid gap-1">
                    {{ $buttons }}
                    @if (Auth::user()->role === UserRole::CLIENT->value)
                        <x-common::button :ref="route('tariffs.index')" :label="__('gym.change_tariff')"></x-common::button>
                    @endif
                </div>
            </div>
        </div>
    </x-slot:body>
</x-common::card>
