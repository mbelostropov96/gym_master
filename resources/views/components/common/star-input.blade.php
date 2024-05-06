<div class="row mb-3">
    <label for="{{ $id }}" class="col-md-4 col-form-label text-md-end">
        {{ $label }}
    </label>
    <div class="col-md-6">
        <input id="{{ $id }}" class="rating form-control" name="{{ $name }}" value="{{ $value }}"
            type="{{ $type ?? 'text' }}">
    </div>
</div>
