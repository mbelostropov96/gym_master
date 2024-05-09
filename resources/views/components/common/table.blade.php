@php
    use App\View\ValueObject\ButtonTableAction;
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
                        @if (DateTime::createFromFormat('Y-m-d H:i:s', $element->$elementAttribute))
                            @php $element->$elementAttribute = DateTime::createFromFormat('Y-m-d H:i:s', $element->$elementAttribute, new DateTimeZone(date_default_timezone_get()))->format('d.m.Y H:i'); @endphp
                        @endif
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
                                @php $show = true; @endphp
                                @if (!empty($action->condition))
                                    @php $show = false; @endphp
                                    @foreach ($action->condition as $prop => $value)
                                        @if ($element->$prop <= $value)
                                            @php $show = true; @endphp
                                        @endif
                                    @endforeach
                                @endif
                                @if ($show === true)
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
                                                @if (in_array($action->method, ['POST', 'PATCH'], true))
                                                    @foreach ($action->bodyParams as $name => $value)
                                                        <input type="hidden" name="{{ $name }}"
                                                            value="{{ $element->$value }}" />
                                                    @endforeach
                                                @endif
                                            </form>
                                        @break
                                    @endswitch
                                @endif
                            @endforeach
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
