@php
    use App\View\ValueObject\ButtonTableAction;
    use App\View\ValueObject\StarsTableAction;
@endphp
@if ($contents->isEmpty())
    <x-common::alert :type="'warning'" :message="__('gym.table_no_data')" />
@else
    <table class="table">
        <thead>
            <tr>
                @foreach ($columnsName as $name)
                    <th scope="col">{{ (string) $name }}</th>
                @endforeach
                @if ($actions)
                    <th scope="col">{{ __('gym.table_actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($contents as $element)
                <tr
                    @if ($hasClickableRouteWithId()) class="clickable-row"
                data-href="{{ route($clickableRouteWithId, ['id' => $element->id]) }}" @endif>
                    @foreach ($columns as $elementAttribute)
                        @if ($elementAttribute === reset($columns))
                            <th>{{ $element->$elementAttribute }}</th>
                        @else
                            <td>
                                {{ __('gym.' . $element->$elementAttribute) === 'gym.' . $element->$elementAttribute
                                    ? $element->$elementAttribute
                                    : __('gym.' . $element->$elementAttribute) }}
                            </td>
                        @endif
                    @endforeach
                    @if ($actions)
                        <td>
                            @foreach ($actions as $action)
                                @switch(true)
                                    @case($action instanceof ButtonTableAction)
                                        <form method="{{ $action->method === 'GET' ?: 'POST' }}"
                                            @php
$routeParams = [];
                                              foreach ($action->routeParams as $name => $value) {
                                                  $routeParams[$name] = $element->$value;
                                              } @endphp
                                            action="{{ route($action->route, $routeParams) }}">
                                            @csrf
                                            @method($action->method)
                                            <button class="btn btn-{{ $action->buttonType }}" type="submit">
                                                {{ $action->label }}
                                            </button>
                                            @if ($action === 'POST')
                                                @foreach ($params as $name => $value)
                                                    <input type="hidden" name="{{ $name }}"
                                                        value="{{ $value }}" />
                                                @endforeach
                                            @endif
                                        </form>
                                    @break
                                @endswitch
                            @endforeach
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
