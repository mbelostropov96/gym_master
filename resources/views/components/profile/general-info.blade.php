<x-common::card :header-name="__('gym.dashboard')">
    <x-slot:body>
        <div class="row justify-content-center">
            <div class=" col-md-9 col-sm-12">
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
            </div>
            <div class="col-md-3 col-sm-12">
                {{ $buttons }}
            </div>
        </div>
    </x-slot:body>
</x-common::card>
