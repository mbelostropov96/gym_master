@if ($contents->isEmpty())
    <x-common::alert :type="'warning'" :message="__('gym.table_no_data')"/>
@else
    <table class="table">
        <thead>
            <tr>
                @foreach ($columnsName as $name)
                    <th scope="col">{{ (string)$name }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($contents as $element)
                <tr
                    @if($hasClickableRouteWithId())
                        class="clickable-row"
                        data-href="{{ route($clickableRouteWithId, ['id' => $element->id]) }}"
                    @endif
                >
                    @foreach($columns as $num => $elementAttribute)
                        @if($num === 0)
                            <th>{{ $element->$elementAttribute }}</th>
                        @else
                            <td class="text-wrap">
                                {{
                                    __('gym.' . $element->$elementAttribute) === 'gym.' . $element->$elementAttribute
                                        ? $element->$elementAttribute
                                        :  __('gym.' . $element->$elementAttribute)
                                }}
                            </td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
