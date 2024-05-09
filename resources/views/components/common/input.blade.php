<div class="row mb-3">
    <label for="{{ $id }}" class="col-md-4 col-form-label text-md-end">
        {{ $label }}
    </label>
    <div class="col-md-8">
        <input id="{{ $id }}"
            class="
                @error($name)
                    is-invalid
                @enderror
                form-control
            "
            name="{{ $name }}" value="{{ $value }}" type="{{ $type ?? 'string' }}" @readonly($isDisabled)
            @required(!$isDisabled && $isRequired) {{ $attributes }}>
    </div>
</div>
