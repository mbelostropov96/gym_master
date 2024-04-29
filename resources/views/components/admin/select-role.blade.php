@php use App\Enums\UserRole; @endphp
<div class="row mb-3">
    <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('gym.role') }}</label>
    <div class="col-md-6">
        <select name="role" id="role" class="form-select">
            @foreach (UserRole::cases() as $role)
                <option value="{{ $role->value }}"
                        @if ($currentRole === $role->value)
                            selected
                    @endif
                > {{ __('gym.' . $role->value) }} </option>
            @endforeach
        </select>
    </div>
</div>
