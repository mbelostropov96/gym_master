@php use App\Enums\TrainingType; @endphp
<div class="row mb-3">
    <label for="type" class="col-md-4 col-form-label text-md-end">{{ __('gym.training_template_type') }}</label>
    <div class="col-md-6">
        <select name="type" id="type" class="form-select">
            @foreach (TrainingType::cases() as $type)
                <option value="{{ $type->value }}"
                        @if ($currentTrainingType === $type->value)
                            selected
                    @endif
                > {{ __('gym.' . $type->value) }} </option>
            @endforeach
        </select>
    </div>
</div>
