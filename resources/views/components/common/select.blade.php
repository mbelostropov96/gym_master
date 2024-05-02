<div class="row mb-3">
    <label for="{{ $name }}" class="col-md-4 col-form-label text-md-end">{{ $label }}</label>
    <div class="col-md-6">
        <select
            name="{{ $name }}"
            id="{{ $name }}"
            class="form-select"
            @disabled($isDisabled)
        >
            @foreach ($values as $valueId => $value)
                <option value="{{ $useValueId ? $valueId : $value }}" @selected($currentValue === $value)>
                    {{ __('gym.' . $value) === 'gym.' . $value
                        ? $value
                        :  __('gym.' . $value) }}
                </option>
            @endforeach
        </select>
        @if ($isDisabled)
            <input type="hidden" name="{{ $name }}" value="{{
                $useValueId
                    ? array_flip($values)[$currentValue]
                    : $currentValue
                }}"
            />
        @endif
    </div>
</div>
