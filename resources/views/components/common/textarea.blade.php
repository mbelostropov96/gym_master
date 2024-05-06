<div class="row mb-3">

    <label for="{{ $id }}" class="col-md-4 col-form-label text-md-end">
        {{ $label }}
    </label>
    <div class="col-md-6">
        <textarea id="{{ $id }}" rows="3" class="form-control" name="{{ $name }}"
            type="{{ $type ?? 'string' }}" @readonly($isDisabled) @required(!$isDisabled) {{ $attributes }}>{{ $value }}</textarea>
    </div>
</div>
